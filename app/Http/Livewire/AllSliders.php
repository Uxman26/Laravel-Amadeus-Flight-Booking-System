<?php

namespace App\Http\Livewire;

use App\Models\Slider;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class AllSliders extends PowerGridComponent
{
    use ActionButton;

    public $user_id;
    public $amount;
    public $pnr;
    public $type;
    public $description;


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
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function datasource(): \Illuminate\Database\Eloquent\Collection
    {
        return Slider::all();
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
            ->addColumn('image')
            ->addColumn('created_at_formatted', fn (Slider $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
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
            Column::make('Slider', 'image')
                ->sortable()
                ->searchable(),

            Column::make('CREATED AT', 'created_at_formatted', 'created_at')
                ->searchable()
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
     * PowerGrid Transaction Action Buttons.
     *
     * @return array<int, Button>
     */


    public function actions(): array
    {
        return [
            Button::make('delete', 'DELETE')
                ->class('btn btn-danger btn-sm')
                ->emit('delete', ['id' => 'id']),
        ];
    }


    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(),
            [
                'delete',
            ]
        );
    }

    public function delete($id)
    {
        $booking = Slider::find($id['id']);
        $booking->delete();
    }


/*
    public function onUpdatedEditable(string $id, string $field, string $value): void
    {
        Transaction::query()->find($id)->update([
            $field => $value,
        ]);
    }*/

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid Transaction Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($transaction) => $transaction->id === 1)
                ->hide(),
        ];
    }
    */
}
