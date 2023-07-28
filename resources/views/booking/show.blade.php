@extends('layouts.dashboard')

@section('title', 'Reservation Details')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="container">
            <p class="text-center h1 title">DETAILS</p>
            <h1 class="text-center p-5" style="font-family: 'Roboto', sans-serif; text-transform: uppercase">Detailed
                Information</h1>
            <div class="jumbotron">
                <h1 class="display-6">Reservation ID: {{ $booking->id }}</h1>
                <div class="row">
                    <div class="col border">
                        <div class="row">
                            <h5 class="col text-start lead"><b>Reservation</b></h5>
                        </div>
                        <hr class="my-4">
                        <p class="lead">ID: {{ $booking->id }}</p>
                        <p class="lead">Reservation Type: {{ $booking->bookingType->name }}</p>
                        <p class="lead">Reversation Date: {{ $booking->date }}</p>
                        <p class="lead">Return Date: {{ $booking->return_date }}</p>
                        <p class="lead">Booking status:
                            @if ($booking->booking_status == 1)
                                Booked
                            @elseif ($booking->booking_status == 0)
                                Canceled
                            @endif
                        </p>
                        <p class="lead">Payment status:
                            @if ($booking->payment == 1)
                                Paid
                            @else
                                Unpaid
                            @endif
                        </p>
                    </div>
                    <div class="col border">
                        <div class="row">
                            <h5 class="col text-start lead"><b>Customer</b></h5>
                        </div>
                        <hr class="my-4">
                        <p class="lead">ID: {{ $booking->user->id }}</p>
                        <p class="lead">Name: {{ $booking->user->firstname }} {{ $booking->user->lastname }}</p>
                        <p class="lead">Username: {{ $booking->user->username }}</p>
                        <p class="lead">E-mail: {{ $booking->user->email }}</p>
                        <p class="lead">Address: {{ $booking->user->address }}</p>
                        <p class="lead">Contact: {{ $booking->user->contact }}</p>
                    </div>
                    <div class="col border">
                        <div class="row">
                            <h5 class="col text-start lead"><b>Car</b></h5>
                        </div>
                        <hr class="my-4">
                        <p class="lead">ID: {{ $booking->car->id }}</p>
                        <p class="lead">Model: {{ $booking->car->model }}</p>
                        <p class="lead">Brand: {{ $booking->car->brand }}</p>
                        <p class="lead">Model year: {{ $booking->car->model_year }}</p>
                        <p class="lead">Plate Number: {{ $booking->car->plate_number }}</p>
                        <p class="lead">Capacity: {{ $booking->bookingType->people_no }}</p>
                        <p class="lead">Color: {{ $booking->car->color }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
