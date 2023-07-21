<?php

namespace App\DataTables;

use App\Models\ContactUs;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ContactUsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        if (request()->route()->getName() === 'company.messages') {
            return (new EloquentDataTable($query))
                ->addColumn('action', function ($row) {
                    $emailbtn = "<a class='btn btn-primary' data-id='".$row->id."' data-user_id='".$row->user_id."' id='email'>Email</a></div>";
                    return $emailbtn;
                })
                ->setRowId('id');
        } else {
            return (new EloquentDataTable($query))
                ->setRowId('id');
        }
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ContactUs $model): QueryBuilder
    {
        if (request()->route()->getName() === 'admin.messages') {
            return $model->newQuery();
        } elseif (request()->route()->getName() === 'company.messages') {
            $model = ContactUs::query()->where('type', 'emr');
            return $model;
        }
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('contactus-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
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
        if (request()->route()->getName() === 'company.messages') {
            return [
                Column::make('fullname'),
                Column::make('email'),
                Column::make('contact_num'),
                Column::make('message'),
                Column::make('type'),
                Column::make('priority'),
                Column::make('status'),
                Column::computed('action')
                    ->exportable(false)
                    ->printable(false)
                    ->width(60)
                    ->addClass('text-center'),
            ];
        } else {
            return [
                Column::make('fullname'),
                Column::make('email'),
                Column::make('contact_num'),
                Column::make('message'),
                Column::make('type'),
                Column::make('priority'),
                Column::make('status'),
            ];
        }
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ContactUs_' . date('YmdHis');
    }
}
