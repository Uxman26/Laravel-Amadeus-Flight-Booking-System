<?php

namespace App\Http\Livewire\admin;

use App\Mail\PackageConfirmNotification;
use App\Models\PackageBooking;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class PackageBookings extends PowerGridComponent
{
    use ActionButton;
    public $first_name;
    public $last_name;
    public $phone_number;
    public $email;
    public $address;
    public $rooms;
    public $adults;
    public $childrens;
    public $infants;
    public $price;
    public $remaining;
    public $nationality;
    public $received;
    public $payment_method;
    public $invoice_no;
    public $remarks;
    

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
     * @return Builder<\App\Models\User>
     */
    public function datasource(): Builder
    {
        return PackageBooking::query();
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
            ->addColumn('invoice_no')
            ->addColumn('first_name')
            ->addColumn('last_name')
            ->addColumn('phone_number')
            ->addColumn('email')
            ->addColumn('address')
            ->addColumn('nationality')
            ->addColumn('rooms')
            ->addColumn('adults')
            ->addColumn('childrens')
            ->addColumn('infants')
            ->addColumn('price')
            ->addColumn('received')
            ->addColumn('remaining')
            ->addColumn('payment_method')
            ->addColumn('remarks')
            ->addColumn('created_at_formatted', fn (PackageBooking $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'))
            ->addColumn('updated_at_formatted', fn (PackageBooking $model) => Carbon::parse($model->updated_at)->format('d/m/Y H:i:s'));
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
            Column::make('Invoice No', 'invoice_no')
                ->sortable()
                ->editOnClick()
                ->searchable()
                ->makeInputText(),
            Column::make('First Name', 'first_name')
                ->sortable()
                ->editOnClick()
                ->searchable()
                ->makeInputText(),
            Column::make('Last Name', 'last_name')
                ->sortable()
                ->editOnClick()
                ->searchable()
                ->makeInputText(),
            Column::make('Phone Number', 'phone_number')
                ->sortable()
                ->editOnClick()
                ->searchable()
                ->makeInputText(),
            Column::make('Email', 'email')
                ->sortable()
                ->editOnClick()
                ->searchable()
                ->makeInputText(),
            Column::make('Address', 'address')
                ->sortable()
                ->editOnClick()
                ->searchable()
                ->makeInputText(),
                Column::make('Nationality', 'nationality')
                ->sortable()
                ->searchable()
                ->makeInputText(),
            Column::make('Rooms', 'rooms')
                ->sortable()
               
                ->searchable()
                ->makeInputText(),
            Column::make('Adults', 'adults')
                ->sortable()
               
                ->searchable()
                ->makeInputText(),
            Column::make('Childrens', 'childrens')
                ->sortable()
               
                ->searchable()
                ->makeInputText(),
            Column::make('Infants', 'infants')
                ->sortable()
               
                ->searchable()
                ->makeInputText(),
            Column::make('Price', 'price')
                ->sortable()
               
                ->searchable()
                ->makeInputText(),
            Column::make('Received', 'received')
                ->sortable()
                ->editOnClick()
                ->searchable()
                ->makeInputText(),
            Column::make('Remaining', 'remaining')
                ->sortable()
               
                ->searchable()
                ->makeInputText(),
            Column::make('Payment Method', 'payment_method')
                ->sortable()
                ->editOnClick()
                ->searchable()
                ->makeInputText(),
            Column::make('Remarks', 'remarks')
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
     * PowerGrid User Action Buttons.
     *
     * @return array<int, Button>
     */


    public function actions(): array
    {
        return [
            Button::make('printInvoice', 'Print Invoice')
                ->class('btn btn-primary btn-sm')
                ->route('admin.package.invoice', ['id' => 'package_id', 'packageBooking'=> 'id', 'number'=>'invoice_no']),

            Button::make('confirm', 'Confirm')
            ->class('btn btn-primary btn-sm')
            ->emit('confirm', ['id' => 'id']),


        Button::make('cancel', 'Cancel')
            ->class('btn btn-warning btn-sm')
            ->emit('cancel', ['id' => 'id']),

            Button::make('destroy', 'Delete')
                ->class('btn btn-danger btn-sm')
                ->emit('delete', ['id' => 'id']),
        ];
    }



    public function onUpdatedEditable(string $id, string $field, string $value): void
    {
        PackageBooking::query()->find($id)->update([
            $field => $value,
        ]);
        $packageBooking = PackageBooking::findOrFail($id);
        if($field == 'received'){
            PackageBooking::query()->find($id)->update([
                'remaining' => $packageBooking->price - $value,
                'user_id' => auth()->user()->id,
            ]);
            if($packageBooking->price - $value == 0){
                PackageBooking::query()->find($id)->update([
                    'status' => 'confirm',
                ]);
            } else {
                PackageBooking::query()->find($id)->update([
                    'status' => '',
                ]);
            }
        }
        
    }


    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(),
            [
                'confirm',
                'cancel',
                'delete',
            ]
        );
    }



    public function confirm($id)
    {
        $packageBooking = PackageBooking::find($id['id']);
        $packageBooking->status = 'confirm';
        $packageBooking->save();
        if (isset($packageBooking->email)) {
            Mail::to($packageBooking->email)->send(new PackageConfirmNotification($packageBooking));
        }
        Mail::to('travelgondal@gmail.com')->send(new PackageConfirmNotification($packageBooking));
    }
    public function cancel($id)
    {
        $package = PackageBooking::find($id['id']);
        $package->status = 'cancel';
        $package->save();
    }

    public function delete($id)
    {
        $package = PackageBooking::find($id['id']);
        $package->delete();
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid User Action Rules.
     *
     * @return array<int, RuleActions>
     */


    public function actionRules(): array
    {
        return [

            Rule::rows('send_ticket')
                ->when(fn ($booking) => $booking->status == "confirm")
                ->setAttribute('class', 'bg-2'),
            Rule::rows('send_ticket')
                ->when(fn ($booking) => $booking->status == "cancel")
                ->setAttribute('class', 'bg-7'),
            
        ];
    }
}
