@extends('layouts.dashboard')

@section('title', 'Reservations')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <p class="text-center h1 title">RESERVATIONS</p>
            <div class="card">
                <div class="card-body">
                    <div class="row m-0">
                        @forelse ($reservations as $reservation)
                            <div class="col-12 card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-10">
                                            <h5>Reservation</h5>
                                        </div>
                                        <div class="col-2">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
