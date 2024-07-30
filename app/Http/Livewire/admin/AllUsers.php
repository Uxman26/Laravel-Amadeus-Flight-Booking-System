<?php

namespace App\Http\Livewire\admin;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class AllUsers extends PowerGridComponent
{
    use ActionButton;
    public $name;
    public $email;
    public $phone;
    public $password;
    public $role;
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
        return User::query()->where('role', '!=', 3);
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

            /** Example of custom column using a closure **/
            ->addColumn('name_lower', function (User $model) {
                return strtolower(e($model->name));
            })

            ->addColumn('email')
            ->addColumn('phone')
            ->addColumn('role')
            ->addColumn('created_at_formatted', fn (User $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'))
            ->addColumn('updated_at_formatted', fn (User $model) => Carbon::parse($model->updated_at)->format('d/m/Y H:i:s'));
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
            Column::make('NAME', 'name')
                ->sortable()
                ->editOnClick()
                ->searchable()
                ->makeInputText(),

            Column::make('EMAIL', 'email')
                ->sortable()
                ->searchable()
                ->editOnClick()
                ->makeInputText(),

            Column::make('PASSWORD', 'password')
                ->sortable()
                ->searchable()
                ->editOnClick()
                ->makeInputText(),

            Column::make('PHONE', 'phone')
                ->sortable()
                ->searchable()
                ->editOnClick()
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
            Button::make('activate', 'ACTIVATE')
                ->class('btn btn-primary btn-sm')
                ->emit('activate', ['id' => 'id']),


            Button::make('deactivate', 'DE-ACTIVATE')
                ->class('btn btn-danger btn-sm')
                ->emit('deactivate', ['id' => 'id']),

            // Button::make('editPassword', 'RESET-PASSWORD')
            //     ->class('btn btn-secondary btn-sm')
            //     ->emit('editPassword', ['id' => 'id']),

            Button::make('makeAdmin', 'MAKE ADMIN')
                ->class('btn btn-primary btn-sm')
                ->emit('makeAdmin', ['id' => 'id']),

            Button::make('makeAgent', 'MAKE AGENT')
                ->class('btn btn-primary btn-sm')
                ->emit('makeAgent', ['id' => 'id']),
                

            //    Button::make('destroy', 'Delete')
            //        ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
            //        ->route('user.destroy', ['user' => 'id'])
            //        ->method('delete')
        ];
    }



    public function onUpdatedEditable(string $id, string $field, string $value): void
    {
        if($field == 'password'){
            User::query()->find($id)->update([
                $field => Hash::make($value),
            ]);
        } else {
            User::query()->find($id)->update([
                $field => $value,
            ]);
        }
    }


    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(),
            [
                'activate',
                'deactivate',
                'editPassword',
                'makeAdmin',
                'makeAgent'
            ]
        );
    }

    public function makeAdmin($id)
    {
        $user = User::find($id['id']);
        $user->role = 1;
        $user->save();
    }

    public function makeAgent($id)
    {
        $user = User::find($id['id']);
        $user->role = 2;
        $user->save();
    }

    public function activate($id)
    {
        $user = User::find($id['id']);
        $user->status = true;
        $user->save();
    }


    public function deactivate($id)
    {
        $user = User::find($id['id']);
        $user->status = false;
        $user->save();
    }

    public function editPassword($id)
    {
        $user = User::find($id['id']);
        $user->password = Hash::make('12345678');
        $user->save();
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

            //Hide button edit for ID 1
            Rule::button('activate')
                ->when(fn ($user) => $user->status == 1)
                ->hide(),

            Rule::button('deactivate')
                ->when(fn ($user) => $user->status == 0)
                ->hide(),


            Rule::button('makeAdmin')
                ->when(fn ($user) => $user->role == 1)
                ->hide(),

            Rule::button('makeAgent')
                ->when(fn ($user) => $user->role == 2)
                ->hide(),


            Rule::button('makeAgent')
                ->when(fn ($user) => $user->id == 1)
                ->hide(),
        ];
    }
}
