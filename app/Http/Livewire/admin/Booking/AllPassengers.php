<?php

namespace App\Http\Livewire\admin\Booking;

use App\Models\Booking;
use App\Models\Passenger;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class AllPassengers extends PowerGridComponent
{
    use ActionButton;


    public $booking;
    public $booking_id;
    public $type;
    public $etkt;
    public $title;
    public $firstname;
    public $lastname;
    public $nationality;
    public $dob;
    public $passport;
    public $passport_expiry;


    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
     * PowerGrid datasource.
     *
     * @return Builder<\App\Models\Passenger>
     */
    public function datasource(): Builder
    {
        if($this->booking){
            return Passenger::query()->where('booking_id', $this->booking);
        } else {
            return Passenger::query();
        }
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    | ❗ IMPORTANT: When using closures, you must escape any value coming from
    |    the database using the `e()` Laravel Helper function.
    |
    */
    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('booking', function (Passenger $model) {
                return $model->booking->pnr;
            })
            ->addColumn('type')

            /** Example of custom column using a closure **/
            ->addColumn('type_lower', function (Passenger $model) {
                return strtolower(e($model->type));
            })

            ->addColumn('title')
            ->addColumn('firstname')
            ->addColumn('lastname')
            ->addColumn('nationality')
            ->addColumn('dob')
            ->addColumn('passport')
            ->addColumn('passport_expiry')
            ->addColumn('created_at_formatted', fn (Passenger $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'))
            ->addColumn('updated_at_formatted', fn (Passenger $model) => Carbon::parse($model->updated_at)->format('d/m/Y H:i:s'));
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

    /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Column::make('BOOKING', 'booking')
                ->makeInputRange(),

            Column::make('TYPE', 'type')
                ->sortable()
                ->editOnClick()
                ->searchable()
                ->makeInputText(),

            Column::make('ETKT', 'etkt')
                ->sortable()
                ->editOnClick()
                ->searchable()
                ->makeInputText(),

            Column::make('TITLE', 'title')
                ->sortable()
                ->searchable()
                ->editOnClick()
                ->makeInputText(),

            Column::make('FIRSTNAME', 'firstname')
                ->sortable()
                ->searchable()
                ->editOnClick()
                ->makeInputText(),

            Column::make('LASTNAME', 'lastname')
                ->sortable()
                ->searchable()
                ->editOnClick()
                ->makeInputText(),

            Column::make('NATIONALITY', 'nationality')
                ->sortable()
                ->searchable()
                ->editOnClick()
                ->makeInputText(),

            Column::make('DOB', 'dob')
                ->sortable()
                ->searchable()
                ->editOnClick()
                ->makeInputText(),

            Column::make('PASSPORT', 'passport')
                ->sortable()
                ->editOnClick()
                ->searchable()
                ->makeInputText(),

            Column::make('PASSPORT', 'passport_expiry')
                ->sortable()
                ->editOnClick()
                ->searchable()
                ->makeInputText(),

            Column::make('CREATED AT', 'created_at_formatted', 'created_at')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker(),

        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

    /**
     * PowerGrid Passenger Action Buttons.
     *
     * @return array<int, Button>
     */

    /*
    public function actions(): array
    {
       return [
           Button::make('edit', 'Edit')
               ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
               ->route('passenger.edit', ['passenger' => 'id']),

           Button::make('destroy', 'Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('passenger.destroy', ['passenger' => 'id'])
               ->method('delete')
        ];
    }
    */


    public function onUpdatedEditable(string $id, string $field, string $value): void
    {
        Passenger::query()->find($id)->update([
            $field => $value,
        ]);

        $passenger = Passenger::find($id);

        if ($field == "etkt") {
            // adding transaction for this booking
            $transaction = new Transaction();
            $transaction->user_id = auth()->user()->id;
            $transaction->amount = $passenger->booking->admin_buy_price;
            $transaction->type = "Ticket Book";
            $transaction->sum = false;
            $transaction->description = "PNR: " . $passenger->booking->pnr . " Ticket Book";
            $transaction->save();

            $booking = Booking::find($passenger->booking->id);
            $booking->ticket_status = "issued";
            $booking->save();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid Passenger Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($passenger) => $passenger->id === 1)
                ->hide(),
        ];
    }
    */
}
