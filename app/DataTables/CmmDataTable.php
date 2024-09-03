<?php

namespace App\DataTables;

use App\Models\Cmm;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CmmDataTable extends DataTable
{

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('img', function ($cmm) {
                $imageUrl = asset('storage/image/cmm/' . $cmm->img);
                return '<img src="' . $imageUrl . '" height="50px" class="cmm-image" data-bs-toggle="modal" data-bs-target="#imageModal" data-image-url="' . $imageUrl . '" data-title="' . e($cmm->title) . '">';
            })
            ->addColumn('action', function ($cmm) {
                $editUrl = route('admin.cmms.edit', $cmm->id); // URL для
                // редактирования CMM
                $deleteUrl = route('admin.cmms.destroy', $cmm->id); // URL для
                // удаления CMM

                return '
                <a href="' . $editUrl . '" class="btn btn-sm btn-primary">Edit</a>
                <form action="' . $deleteUrl . '" method="POST" style="display:inline;">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure you want to delete this item?\');">Delete</button>
                </form>
            ';
            })
            ->rawColumns(['img', 'action']);
    }

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
//    public function dataTable(QueryBuilder $query): EloquentDataTable
//    {
//        return (new EloquentDataTable($query))
//            ->addColumn('action', 'cmm.action')
//            ->setRowId('id');
//    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Cmm $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html()
//    : HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('cmm-table')
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
    public function getColumns()
//    : array
    {
        return [
//            Column::computed('action')
//                  ->exportable(false)
//                  ->printable(false)
//                  ->width(60)
//                  ->addClass('text-center'),
//            Column::make('id'),
//            Column::make('add your columns'),
//            Column::make('created_at'),
//            Column::make('updated_at'),

//            Column::make('id'),
            Column::make('number')->width('60'),
            Column::make('title')->width('200'),
            Column::make('img')->title('Image')->width('60'),
            Column::make('revision_date')->width('150'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Cmm_' . date('YmdHis');
    }
}
