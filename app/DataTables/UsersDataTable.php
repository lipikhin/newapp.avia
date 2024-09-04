<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('roles_id', function ($user) {
                return $this->getRoleSelect($user->roles_id, $user->id);
            })
            ->addColumn('teams_id', function ($user) {
                return $this->getTeamSelect($user->teams_id, $user->id);
            })
            ->addColumn('action', 'users.action')
            ->setRowId('id')
            ->rawColumns(['avatar', 'is_admin', 'roles_id', 'teams_id', 'action']);
    }

    protected function getRoleSelect($currentRoleId, $userId)
    {
        $roles = \App\Models\Role::all();
        $options = '<select class="form-select change-role" data-id="' . $userId . '">';
        $options .= '<option value="">Select Role</option>';
        foreach ($roles as $role) {
            $selected = $role->id == $currentRoleId ? 'selected' : '';
            $options .= '<option value="' . $role->id . '" ' . $selected . '>' . $role->name . '</option>';
        }
        $options .= '</select>';
        return $options;
    }

    protected function getTeamSelect($currentTeamId, $userId)
    {
        $teams = \App\Models\Team::all();
        $options = '<select class="form-select change-team" data-id="' . $userId . '">';
        $options .= '<option value="">Select Team</option>';
        foreach ($teams as $team) {
            $selected = $team->id == $currentTeamId ? 'selected' : '';
            $options .= '<option value="' . $team->id . '" ' . $selected . '>' . $team->name . '</option>';
        }
        $options .= '</select>';
        return $options;
    }




    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('users-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
//                        Button::make('excel'),
//                        Button::make('csv'),
//                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
//            Column::make('id'),
            Column::make('avatar')->title('Аватар')->width('5%'), //
            // Обозначение
            // столбца
            // с аватаром
            Column::make('name')->title('Name'),
            Column::make('email')->title('Email'),
            Column::make('is_admin')->title('Admin'),
            Column::make('roles.id')->title('Role'),
            Column::make('teams_id')->title('Team'),
            Column::make('phone')->title('Phone'),
            Column::make('stamp')->title('Stamp'),
//            Column::make('created_at'),
//            Column::make('updated_at'),
        ];


//            Column::computed('action')
//                  ->exportable(false)
//                  ->printable(false)
//                  ->width(60)
//                  ->addClass('text-center'),
//            Column::make('id'),
//            Column::make('add your columns'),
//            Column::make('created_at'),
//            Column::make('updated_at'),

    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
