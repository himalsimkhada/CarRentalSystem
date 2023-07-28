<?php

namespace App\DataTables;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BookingsDataTable extends DataTable
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
                $paybtn = "";
                $delbtn = "";
                if (auth()->user()->user_type === 3 && $row->payment == 0) {
                    $paybtn = "<a id='paymentLink' data-id='" . $row->id . "' class='btn btn-warning d-flex justify-content-center'><span class='material-icons'>payments</span></a>";
                }
                if (auth()->guard('company')->check()) {
                    $detailbtn = "<a href='" . route('company.show.booking', ['id' => $row->id]) . "' class='btn btn-info d-flex justify-content-center'><span class='material-icons'>info</span></a>";
                } elseif (auth()->check()) {
                    $detailbtn = "<a href='" . route('user.show.booking', ['id' => $row->id]) . "' class='btn btn-info d-flex justify-content-center'><span class='material-icons'>info</span></a>";
                }
                if (auth()->check() && auth()->user()->user_type === 3 && $row->payment == 0) {
                    $delbtn = "<a data-id='" . $row->id . "' class='btn btn-danger d-flex justify-content-center' id='delete'><span class='material-icons'>delete</span></a>";
                }
                $btns = "<div class=btn-group>" . $paybtn . $detailbtn . $delbtn . "</div>";
                return $btns;
            })
            ->editColumn('payment', function ($row) {
                if ($row->payment == 1) {
                    return "Paid";
                } else {
                    return "Not paid";
                }
            })
            ->editColumn('booking_type', function ($row) {
                return $row->bookingType->name;
            })
            ->editColumn('car_plate_number', function ($row) {
                return $row->car->plate_number;
            })
            ->editColumn('user', function ($row) {
                return $row->user->username;
            })
            ->editColumn('location', function ($row) {
                return $row->location->name;
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Booking $model): QueryBuilder
    {
        if (auth()->guard('company')->check()) {
            $company_id = auth()->guard('company')->user()->id;
            $bookings = Booking::with(['user', 'car', 'bookingType'])
                ->whereHas('car.company', function ($query) use ($company_id) {
                    $query->where('id', $company_id);
                });
            return $bookings;
        } elseif (auth()->check() && auth()->user()->user_type === 1) {
            $bookings = Booking::with(['user', 'car', 'bookingType']);
            return $bookings;
        } elseif (auth()->check() && auth()->user()->user_type === 3) {
            $user = auth()->user();
            $bookings = Booking::with(['user', 'car', 'bookingType'])
                ->where('user_id', $user->id);
            return $bookings;
        }
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('bookings-table')
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
            Column::make('booking_date'),
            Column::make('return_date'),
            Column::make('status'),
            Column::make('payment'),
            Column::make('booking_type'),
            Column::make('car_plate_number'),
            Column::make('user'),
            Column::make('location'),
            Column::make('final_cost'),
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
        return 'Bookings_' . date('YmdHis');
    }
}
