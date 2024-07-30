<?php

namespace App\Http\Livewire\admin;

use App\Models\Package;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class Packages extends PowerGridComponent
{
    use ActionButton;
    public $name;
    public $single_room_price;
    public $double_room_price;
    public $triple_room_price;
    public $quadruple_room_price;
    public $children_price_deduction;
    public $infant_price;
    public $mecca_hotel;
    public $madina_hotel;
    public $description;
    public $departure;
    public $arrival;
    

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
        return Package::query();
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
            ->addColumn('name')
            ->addColumn('single_room_price')
            ->addColumn('double_room_price')
            ->addColumn('triple_room_price')
            ->addColumn('quadruple_room_price')
            ->addColumn('children_price_deduction')
            ->addColumn('infant_price')
            ->addColumn('mecca_hotel')
            ->addColumn('madina_hotel')
            ->addColumn('description')
            ->addColumn('departure')
            ->addColumn('arrival')
            ->addColumn('created_at_formatted', fn (Package $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'))
            ->addColumn('updated_at_formatted', fn (Package $model) => Carbon::parse($model->updated_at)->format('d/m/Y H:i:s'));
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
            Column::make('Name', 'name')
                ->sortable()
                ->editOnClick()
                ->searchable()
                ->makeInputText(),
            Column::make('Single Room Price', 'single_room_price')
                ->sortable()
                ->editOnClick()
                ->searchable()
                ->makeInputText(),
            Column::make('Double Room Price', 'double_room_price')
                ->sortable()
                ->editOnClick()
                ->searchable()
                ->makeInputText(),
            Column::make('Tiple Room Price', 'triple_room_price')
                ->sortable()
                ->editOnClick()
                ->searchable()
                ->makeInputText(),
            Column::make('Quadruple Room Price', 'quadruple_room_price')
                ->sortable()
                ->editOnClick()
                ->searchable()
                ->makeInputText(),
            Column::make('Childen Price Deduction', 'children_price_deduction')
                ->sortable()
                ->editOnClick()
                ->searchable()
                ->makeInputText(),
            Column::make('Infant Price', 'infant_price')
                ->sortable()
                ->editOnClick()
                ->searchable()
                ->makeInputText(),
           
            Column::make('Mecca Hotel', 'mecca_hotel')
                ->sortable()
                ->editOnClick()
                ->searchable()
                ->makeInputText(),
            Column::make('Madina Hotel', 'madina_hotel')
                ->sortable()
                ->editOnClick()
                ->searchable()
                ->makeInputText(),
            Column::make('Description', 'description')
                ->sortable()
                ->searchable()
                ->makeInputText(),
            Column::make('Departure', 'departure')
                ->sortable()
                ->editOnClick()
                ->searchable()
                ->makeInputDatePicker(),
            Column::make('Arrival', 'arrival')
                ->sortable()
                ->editOnClick()
                ->searchable()
                ->makeInputDatePicker(),

            

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
            Button::make('activate', 'ACTIVATE')
                ->class('btn btn-primary btn-sm')
                ->emit('activate', ['id' => 'id']),


            Button::make('deactivate', 'DE-ACTIVATE')
                ->class('btn btn-warning btn-sm')
                ->emit('deactivate', ['id' => 'id']),

            Button::make('edit', 'Edit')
                ->class('btn btn-info btn-sm')
                ->route('admin.package.edit', ['package' => 'id']),


            Button::make('destroy', 'Delete')
                ->class('bg-red-500 btn-sm cursor-pointer text-white px-3 py-2 m-1 rounded text-sm btn btn-danger btn-sm')
                ->emit('delete', ['id' => 'id']),
        ];
    }



    public function onUpdatedEditable(string $id, string $field, string $value): void
    {
        Package::query()->find($id)->update([
            $field => $value,
        ]);
    }


    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(),
            [
                'activate',
                'deactivate',
                'delete',
            ]
        );
    }



    public function activate($id)
    {
        $package = Package::find($id['id']);
        $package->status = true;
        $package->save();
    }


    public function deactivate($id)
    {
        $package = Package::find($id['id']);
        $package->status = false;
        $package->save();
    }

  
    public function delete($id)
    {
        $package = Package::find($id['id']);
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

            
            
        ];
    }
}
