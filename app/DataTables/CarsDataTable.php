<?php

namespace App\DataTables;

use App\Models\Car;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CarsDataTable extends DataTable
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
                $editbutton = "<a href='" . route('company.edit.car', ['id' => Crypt::encrypt($row->id)]) . "' class='btn btn-primary d-flex justify-content-center'><span class='material-icons'>edit</span></a>";
                $deletebtn = "<a class='btn btn-danger d-flex justify-content-center' data-id='" . $row->id . "' id='delete'><span class='material-icons mr-1'>
        delete
    </span></a>";
                $addimgbtn = "<a class='btn btn-info d-flex justify-content-center' data-id='" . $row->id . "' id='image'><span class='material-icons'>
                add
            </span></a>";

                if (auth()->guard('company')->check()) {
                    $btns = $editbutton . $addimgbtn . $deletebtn;
                } else {
                    $btns = $deletebtn;
                }

                return "<div class='btn-group'>" . $btns . "</div>";
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Car $model): QueryBuilder
    {
        if (auth()->guard('company')->check() && request()->route()->getName() === 'company.index.car') {
            $model = Car::query()->where('company_id', auth()->guard('company')->user()->id);
            return $model;
        } elseif (auth()->check() && request()->route()->getName() === 'admin.index.car') {
            return $model->newQuery();
        }
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('cars-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(0, 'asc')
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
            Column::make('id'),
            Column::make('model'),
            Column::make('model_year'),
            Column::make('brand'),
            Column::make('color'),
            Column::make('plate_number'),
            Column::make('availability'),
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
        return 'Cars_' . date('YmdHis');
    }
}
