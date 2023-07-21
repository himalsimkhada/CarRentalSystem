@extends('layouts.dashboard')

@section('title', 'Reservations')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <p class="text-center h1 title">RESERVATION</p>
            <div class="card">
                <div class="dropdown text-right">
                    <button class="btn btn-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Sort By
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{ route('company.list.reservations') }}">All</a>
                        <a class="dropdown-item" href="{{ route('company.list.reservations.paid') }}">Paid</a>
                        <a class="dropdown-item" href="{{ route('company.list.reservations.unpaid') }}">Unpaid</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row m-0">
                        @if (\Route::current()->getName() == 'company.list.reservations.paid')
                            @forelse ($srtPaid as $reservation)
                                <div class="col-12 card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-10">
                                                <h5>Reservation</h5>
                                            </div>
                                            <div class="col-2">
                                                <a href="{{ route('company.reservation.detail', ['reservation-id' => $reservation->booking_id]) }}"
                                                    class="btn btn-info form-control">Details <span
                                                        class="material-icons align-middle float-right">
                                                        info
                                                    </span></a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <p class="card-text">
                                        <ul class="list-unstyled">
                                            <h6>Information</h6>
                                            <div class="row">
                                                <div class="col-12">
                                                    <li>User ID: <b>{{ $reservation->user_id }}</b></li>
                                                    <li>User Email: <b>{{ $reservation->email }}</b></li>
                                                    <li>Booking Type: <b>{{ $reservation->type_name }}</b></li>
                                                    <li>Car Model: <b>{{ $reservation->model }}</b></li>
                                                    <li>Pick-up Date: <b>{{ $reservation->date }}</b></li>
                                                    <li>Drop Date: <b>{{ $reservation->return_date }}</b></li>
                                                    <li>Payment Status:
                                                        @if ($reservation->payment == 1)
                                                            <b style="font-size: larger" class="text-success">Paid</b>
                                                        @else
                                                            <b style="font-size: larger" class="text-danger">Unpaid</b>
                                                        @endif
                                                    </li>
                                                </div>
                                            </div>
                                        </ul>
                                        </p>
                                    </div>
                                    <div class="card-footer text-muted">
                                        Reservation date: {{ $reservation->date }}
                                    </div>
                                </div>
                            @empty
                                There are no reservations
                            @endforelse
                        @elseif (\Route::current()->getName() == 'company.list.reservations.unpaid')
                            @forelse ($srtUnpaid as $reservation)
                                <div class="col-12 card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-10">
                                                <h5>Reservation</h5>
                                            </div>
                                            <div class="col-2">
                                                <a href="{{ route('company.reservation.detail', ['reservation-id' => $reservation->booking_id]) }}"
                                                    class="btn btn-info form-control">Details <span
                                                        class="material-icons align-middle float-right">
                                                        info
                                                    </span></a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <p class="card-text">
                                        <ul class="list-unstyled">
                                            <h6>Information</h6>
                                            <div class="row">
                                                <div class="col-12">
                                                    <li>User ID: <b>{{ $reservation->user_id }}</b></li>
                                                    <li>User Email: <b>{{ $reservation->email }}</b></li>
                                                    <li>Booking Type: <b>{{ $reservation->type_name }}</b></li>
                                                    <li>Car Model: <b>{{ $reservation->model }}</b></li>
                                                    <li>Pick-up Date: <b>{{ $reservation->date }}</b></li>
                                                    <li>Drop Date: <b>{{ $reservation->return_date }}</b></li>
                                                    <li>Payment Status:
                                                        @if ($reservation->payment == 1)
                                                            <b style="font-size: larger" class="text-success">Paid</b>
                                                        @else
                                                            <b style="font-size: larger" class="text-danger">Unpaid</b>
                                                        @endif
                                                    </li>
                                                </div>
                                            </div>
                                        </ul>
                                        </p>
                                    </div>
                                    <div class="card-footer text-muted">
                                        Reservation date: {{ $reservation->date }}
                                    </div>
                                </div>
                            @empty
                                There are no reservations
                            @endforelse
                        @else
                            @forelse ($reservations as $reservation)
                                <div class="col-12 card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-10">
                                                <h5>Reservation</h5>
                                            </div>
                                            <div class="col-2">
                                                <a href="{{ route('company.reservation.detail', ['reservation-id' => $reservation->booking_id]) }}"
                                                    class="btn btn-info form-control">Details <span
                                                        class="material-icons align-middle float-right">
                                                        info
                                                    </span></a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <p class="card-text">
                                        <ul class="list-unstyled">
                                            <h6>Information</h6>
                                            <div class="row">
                                                <div class="col-12">
                                                    <li>User ID: <b>{{ $reservation->user_id }}</b></li>
                                                    <li>User Email: <b>{{ $reservation->email }}</b></li>
                                                    <li>Booking Type: <b>{{ $reservation->type_name }}</b></li>
                                                    <li>Car Model: <b>{{ $reservation->model }}</b></li>
                                                    <li>Pick-up Date: <b>{{ $reservation->date }}</b></li>
                                                    <li>Drop Date: <b>{{ $reservation->return_date }}</b></li>
                                                    <li>Payment Status:
                                                        @if ($reservation->payment == 1)
                                                            <b style="font-size: larger" class="text-success">Paid</b>
                                                        @else
                                                            <b style="font-size: larger" class="text-danger">Unpaid</b>
                                                        @endif
                                                    </li>
                                                </div>
                                            </div>
                                        </ul>
                                        </p>
                                    </div>
                                    <div class="card-footer text-muted">
                                        Reservation date: {{ $reservation->date }}
                                    </div>
                                </div>
                            @empty
                                There are no reservations
                            @endforelse
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
