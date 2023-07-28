<?php

namespace App\DataTables;

use App\Models\UserCredential;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserCredentialsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                $editbutton = "<a href='" . route('user.edit.credential', ['id' => $row->id]) . "' class='btn btn-primary d-flex justify-content-center'><span class='material-icons'>edit</span></a>";
                $deletebtn = "<a class='btn btn-danger d-flex justify-content-center' data-id='" . $row->id . "' id='delete'><span class='material-icons'>
        delete
    </span></a>";
                return "<div class='btn-group'>" . $editbutton . $deletebtn . "</div>";
            })
            ->editColumn('file', function ($row) {
                $file = "<a href='" . asset('user/credentials/files/' . $row->file) . "' class='text-info'>Download</a>";
                return $file;
            })
            ->editColumn('image', function ($row) {
                $image = "<a href='" . asset('user/credentials/images/' . $row->image) . "' class='text-info'>Download</a>";
                return $image;
            })
            ->rawColumns(['file', 'image', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(UserCredential $model): QueryBuilder
    {
        // $company_id = CarCompany::where('owner_id', auth()->user()->id)->first();
        $model = UserCredential::where('user_id', auth()->user()->id);
        return $model;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('usercredentials-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('add'),
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload'),
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('name'),
            Column::make('reg_number'),
            Column::make('file'),
            Column::make('image'),
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
        return 'UserCredentials_' . date('YmdHis');
    }
}
