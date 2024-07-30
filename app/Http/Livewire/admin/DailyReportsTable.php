<?php

namespace App\Http\Livewire\admin;

use App\Mail\OrderCancelledNotification;
use App\Mail\OrderCompleteNotification;
use App\Mail\OrderOpenedNotification;
use App\Mail\OrderReopenedNotification;
use App\Mail\TicketNotification;
use App\Models\DailyReport;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class DailyReportsTable extends PowerGridComponent
{
    use ActionButton;
    public $order_no;
    public $firstname;
    public $lastname;
    public $email;
    public $phone_number;
    public $flexible_date;
    public $preffered_airline;
    public $trip_type;
    public $flight_type;
    public $routes;
    public $origin1;
    public $destination1;
    public $departureDate1;
    public $returnDate1;
    public $origin2;
    public $destination2;
    public $departureDate2;
    public $origin3;
    public $destination3;
    public $departureDate3;
    public $origin4;
    public $destination4;
    public $departureDate4;
    public $adults;
    public $children;
    public $infants;
    public $remark;
    public $status;



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
            Header::make()
                ->showSearchInput()
                ->showToggleColumns(),
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
     * @return Builder<\App\Models\DailyReport>
     */
    public function datasource(): Builder
    {
        return DailyReport::query()->latest();
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
    |    the database using the e() Laravel Helper function.
    |
    */
    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('order_no')
            ->addColumn('firstname')
            ->addColumn('lastname')
            ->addColumn('email')
            ->addColumn('phone_number')
            ->addColumn('flexible_date')
            ->addColumn('preffered_airline')
            ->addColumn('trip_type')
            ->addColumn('flight_type')
            ->addColumn('routes', function (DailyReport $model) {
                if ($model->trip_type == 'oneway') {
                    return $model->origin1 .'-->'. $model->destination1 .'-->'. $model->departureDate1;
                } elseif ($model->trip_type == 'return') {
                    return $model->origin1 .'-->'. $model->destination1 .'-->'. $model->departureDate1 .'-->'. $model->returnDate1;
                } else {
                    return $model->origin1 .'-->'. $model->destination1 .'-->'. $model->departureDate1 .'-->'.
                    $model->origin2 ?? null .'-->'. $model->destination2 ?? null .'-->'. $model->departureDate2 ?? null .'-->'.
                    $model->origin3 ?? null.'-->'. $model->destination3 ?? null.'-->'. $model->departureDate3 ?? null.'-->'.
                    $model->origin4 ?? null .'-->'. $model->destination4 ?? null .'-->'. $model->departureDate4 ?? null ;
                }
                return $model->user ? $model->user->name : null;
            })
            ->addColumn('origin1')
            ->addColumn('destination1')
            ->addColumn('departureDate1')
            ->addColumn('returnDate1')
            ->addColumn('origin2')
            ->addColumn('destination2')
            ->addColumn('departureDate2')
            ->addColumn('origin3')
            ->addColumn('destination3')
            ->addColumn('departureDate3')
            ->addColumn('origin4')
            ->addColumn('destination4')
            ->addColumn('departureDate4')
            ->addColumn('adults')
            ->addColumn('children')
            ->addColumn('infants')
            ->addColumn('remark')
            ->addColumn('status')
            ->addColumn('user', function (DailyReport $model) {
                return $model->user ? $model->user->name : null;
            })
            ->addColumn('created_at_formatted', fn (DailyReport $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'))
            ->addColumn('updated_at_formatted', fn (DailyReport $model) => Carbon::parse($model->updated_at)->format('d/m/Y H:i:s'));
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
            

            Column::make('ORDER NO', 'order_no')
                ->sortable()
                ->searchable()
                ->makeInputText()
                ->searchable(),
            Column::make('FIRST NAME', 'firstname')
                ->sortable()
                ->searchable()
                ->makeInputText()
                ->editOnClick()
                ->searchable(),
            Column::make('LAST NAME', 'lastname')
                ->sortable()
                ->searchable()
                ->makeInputText()
                ->editOnClick()
                ->searchable(),
            Column::make('EMAIL', 'email')
                ->sortable()
                ->searchable()
                ->makeInputText()
                ->editOnClick()
                ->searchable(),
            Column::make('PHONE NUMBER', 'phone_number')
                ->sortable()
                ->searchable()
                ->makeInputText()
                ->editOnClick()
                ->searchable(),
            Column::make('FLEXIBLE DATE', 'flexible_date')
                ->sortable()
                ->searchable()
                ->makeInputText()
                ->editOnClick()
                ->searchable(),
            Column::make('PREFFERED AIRLINE', 'preffered_airline')
                ->sortable()
                ->searchable()
                ->makeInputText()
                ->editOnClick()
                ->searchable(),
            Column::make('TRIP TYPE', 'trip_type')
                ->sortable()
                ->searchable()
                ->makeInputText()
                ->editOnClick()
                ->searchable(),
                Column::make('FLIGHT TYPE', 'flight_type')
                ->sortable()
                ->searchable()
                ->makeInputText()
                ->searchable(),
            Column::make('ROUTES', 'routes')
                ->sortable()
                ->searchable()
                ->makeInputText()
                ->searchable(),
            // Column::make('ORIGIN 1', 'origin1')
            //     ->sortable()
            //     ->searchable()
            //     ->makeInputText()
            //     ->editOnClick()
            //     ->searchable(),
            // Column::make('DESTINATION 1', 'destination1')
            //     ->sortable()
            //     ->searchable()
            //     ->makeInputText()
            //     ->editOnClick()
            //     ->searchable(),
            // Column::make('DEPARTURE DATE 1', 'departureDate1')
            //     ->sortable()
            //     ->searchable()
            //     ->makeInputText()
            //     ->editOnClick()
            //     ->searchable(),
            // Column::make('RETURN DATE', 'returnDate1')
            //     ->sortable()
            //     ->searchable()
            //     ->makeInputText()
            //     ->editOnClick()
            //     ->searchable(),
            // Column::make('ORIGIN 2', 'origin2')
            //     ->sortable()
            //     ->searchable()
            //     ->makeInputText()
            //     ->editOnClick()
            //     ->searchable(),
            // Column::make('DESTINATION 2', 'destination2')
            //     ->sortable()
            //     ->searchable()
            //     ->makeInputText()
            //     ->editOnClick()
            //     ->searchable(),
            // Column::make('DEPARTURE DATE 2', 'departureDate2')
            //     ->sortable()
            //     ->searchable()
            //     ->makeInputText()
            //     ->editOnClick()
            //     ->searchable(),
            // Column::make('ORIGIN 3', 'origin3')
            //     ->sortable()
            //     ->searchable()
            //     ->makeInputText()
            //     ->editOnClick()
            //     ->searchable(),
            // Column::make('DESTINATION 3', 'destination3')
            //     ->sortable()
            //     ->searchable()
            //     ->makeInputText()
            //     ->editOnClick()
            //     ->searchable(),
            // Column::make('DEPARTURE DATE 3', 'departureDate3')
            //     ->sortable()
            //     ->searchable()
            //     ->makeInputText()
            //     ->editOnClick()
            //     ->searchable(),
            // Column::make('ORIGIN 4', 'origin4')
            //     ->sortable()
            //     ->searchable()
            //     ->makeInputText()
            //     ->editOnClick()
            //     ->searchable(),
            // Column::make('DESTINATION 4', 'destination4')
            //     ->sortable()
            //     ->searchable()
            //     ->makeInputText()
            //     ->editOnClick()
            //     ->searchable(),
            // Column::make('DEPARTURE DATE 4', 'departureDate4')
            //     ->sortable()
            //     ->searchable()
            //     ->makeInputText()
            //     ->editOnClick()
            //     ->searchable(),
            Column::make('ADULTS', 'adults')
                ->sortable()
                ->searchable()
                ->makeInputText()
                ->editOnClick()
                ->searchable(),
            Column::make('CHILDREN', 'children')
                ->sortable()
                ->searchable()
                ->makeInputText()
                ->editOnClick()
                ->searchable(),
            Column::make('INFANTS', 'infants')
                ->sortable()
                ->searchable()
                ->makeInputText()
                ->editOnClick()
                ->searchable(),


            Column::make('REMARK', 'remark')
                ->sortable()
                ->searchable()
                ->editOnClick()
                ->makeInputText()
                ->editOnClick(),
            Column::make('STATUS', 'status')
                ->sortable()
                ->searchable()
                ->editOnClick()
                ->makeInputText(),
                Column::make('Agent', 'user')
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
     * PowerGrid DailyReport Action Buttons.
     *
     * @return array<int, Button>
     */


    public function actions(): array
    {
        return [


            Button::make('assign', 'ASSIGN TO ME')
                ->class('btn btn-danger btn-sm')
                ->emit('assign', ['id' => 'id']),
            Button::make('complete', 'Done')
                ->class('btn btn-danger btn-sm')
                ->emit('complete', ['id' => 'id']),


            Button::make('cancel', 'CANCEL')
                ->class('btn btn-danger btn-sm')
                ->emit('cancel', ['id' => 'id']),

            // Button::make('open', 'OPEN')
            //     ->class('btn btn-danger btn-sm')
            //     ->emit('open', ['id' => 'id']),
            // Button::make('reopen', 'RE-OPEN')
            //     ->class('btn btn-danger btn-sm')
            //     ->emit('reopen', ['id' => 'id']),


            Button::make('delete', 'DELETE')
                ->class('btn btn-danger btn-sm')
                ->emit('delete', ['id' => 'id']),

            

        ];
    }


    public function onUpdatedEditable(string $id, string $field, string $value): void
    {
        DailyReport::query()->find($id)->update([
            $field => $value,
        ]);
    }


    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(),
            [
                'assign',
                'cancel',
                // 'open',
                // 'reopen',
                'delete',
                'complete',
            ]
        );
    }




    public function assign($id)
    {
        $DailyReport = DailyReport::find($id['id']);
        $DailyReport->user_id =auth()->user()->id;
        $DailyReport->status = 'assigned';
        $DailyReport->save();
    }
    public function complete($id)
    {
        $DailyReport = DailyReport::find($id['id']);
        $DailyReport->user_id =auth()->user()->id;
        $DailyReport->status = 'complete';
        Mail::to($DailyReport->email)->send(new OrderCompleteNotification($DailyReport));
        Mail::to(option('admin_email'))->send(new OrderCompleteNotification($DailyReport));
        Mail::to('ordergondaltravel@gmail.com')->send(new OrderCompleteNotification($DailyReport));
        $DailyReport->save();
    }
    public function cancel($id)
    {
        $DailyReport = DailyReport::find($id['id']);
        $DailyReport->status = 'cancelled';
        $DailyReport->save();
        Mail::to($DailyReport->email)->send(new OrderCancelledNotification($DailyReport));
        Mail::to(option('admin_email'))->send(new OrderCancelledNotification($DailyReport));
        Mail::to('ordergondaltravel@gmail.com')->send(new OrderCancelledNotification($DailyReport));
    }
    // public function open($id)
    // {
    //     $DailyReport = DailyReport::find($id['id']);
    //     $DailyReport->status = 'open';
    //     Mail::to($DailyReport->email)->send(new OrderOpenedNotification($DailyReport));
    //     Mail::to(option('admin_email'))->send(new OrderOpenedNotification($DailyReport));
    //     Mail::to('ordergondaltravel@gmail.com')->send(new OrderOpenedNotification($DailyReport));
    //     $DailyReport->save();
    // }
    // public function reopen($id)
    // {
    //     $DailyReport = DailyReport::find($id['id']);
    //     $DailyReport->status = 'open';
    //     $DailyReport->save();
    //     Mail::to($DailyReport->email)->send(new OrderReopenedNotification($DailyReport));
    //     Mail::to(option('admin_email'))->send(new OrderReopenedNotification($DailyReport));
    //     Mail::to('ordergondaltravel@gmail.com')->send(new OrderReopenedNotification($DailyReport));
    // }
    public function delete($id)
    {
        $DailyReport = DailyReport::find($id['id']);
        $DailyReport->delete();
    }


    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid DailyReport Action Rules.
     *
     * @return array<int, RuleActions>
     */


    public function actionRules(): array
    {
        return [


            Rule::button('open')
                ->when(fn ($DailyReport) => $DailyReport->status != "pending")
                ->hide(),
            Rule::button('complete')
                ->when(fn ($DailyReport) => $DailyReport->status != "assigned")
                ->hide(),
            Rule::button('reopen')
                ->when(fn ($DailyReport) => $DailyReport->status != "cancelled")
                ->hide(),
            Rule::button('cancel')
                ->when(fn ($DailyReport) => $DailyReport->status != "assigned")
                ->hide(),
            Rule::button('assign')
                ->when(fn ($DailyReport) => $DailyReport->status != "open")
                ->hide(),

            Rule::rows('send_ticket')
                ->when(fn ($DailyReport) => $DailyReport->status == "open" )
                ->setAttribute('class', 'bg-8'),

            Rule::rows('send_ticket')
                ->when(fn ($DailyReport) => $DailyReport->status == "cancelled")
                ->setAttribute('class', 'bg-7'),
            Rule::rows('send_ticket')
                ->when(fn ($DailyReport) => $DailyReport->status == 'assigned')
                ->setAttribute('class', 'bg-2'),
            
        ];
    }
}
