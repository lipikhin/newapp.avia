<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id')
            ->addColumn('avatars', function($row) {
                $avatarUrl = asset('avatars/' . $row->avatar); // Путь к картинке
                return '<img src="'.$avatarUrl.'" style="height:50px;cursor:pointer;" onclick="openModal(\''.$avatarUrl.'\')" />';
            })
            ->addColumn('action', function($row) {
                $editUrl = route('admin.users.edit', $row->id); // Ссылка на редактирование
                $deleteUrl = route('admin.users.destroy', $row->id); // Ссылка на удаление

                return '
                <a href="' . $editUrl . '" class="btn btn-sm btn-primary">Edit</a>
                <form action="' . $deleteUrl . '" method="POST" style="display:inline;">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\');">Delete</button>
                </form>
            ';
            })
            ->rawColumns(['avatars', 'action']);
    }

    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->responsive() // Добавьте responsive
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('avatars')
                ->title('Аватар')
                ->responsivePriority(1),

            Column::make('name')
                ->title('Name')
                ->responsivePriority(2),

            Column::make('email')->title('Email')->responsivePriority(4),
            Column::make('is_admin')->title('Admin')->responsivePriority(5),
            Column::make('roles_id')->title('Role')->responsivePriority(6),
            Column::make('teams_id')->title('Team')->responsivePriority(7),
            Column::make('phone')->title('Phone')->responsivePriority(8),
            Column::make('stamp')->title('Stamp')->responsivePriority(9),

            Column::computed('action')
                ->title('Action')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center')
                ->responsivePriority(3),
        ];
    }

    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
