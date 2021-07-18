@extends('layouts.dashboard')

@section('title', 'Reservation Details')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        @foreach ($reservation_details as $details)
            <div class="container">
                <p class="text-center h1 title">DETAILS</p>
                <h1 class="text-center p-5" style="font-family: 'Roboto', sans-serif; text-transform: uppercase">Detailed
                    Information</h1>
                <div class="jumbotron">
                    <h1 class="display-6">Reservation ID: {{ $details->booking_id }}</h1>
                    <div class="row">
                        <div class="col border">
                            <div class="row">
                                <h5 class="col text-left lead"><b>Reservation</b></h5>
                            </div>
                            <hr class="my-4">
                            <p class="lead">ID: {{ $details->booking_id }}</p>
                            <p class="lead">Reservation Type: {{ $details->type_name }}</p>
                            <p class="lead">Reversation Date: {{ $details->date }}</p>
                            <p class="lead">Return Date: {{ $details->return_date }}</p>
                            <p class="lead">Booking status:
                                @if ($details->booking_status == 1)
                                    Booked
                                @elseif ($details->booking_status == 0)
                                    Canceled
                                @endif
                            </p>
                            <p class="lead">Payment status: 
                                @if ($details->payment == 1)
                                    Paid
                                @else
                                    Unpaid
                                @endif
                            </p>
                        </div>
                        <div class="col border">
                            <div class="row">
                                <h5 class="col text-left lead"><b>Customer</b></h5>
                            </div>
                            <hr class="my-4">
                            <p class="lead">ID: {{ $details->user_id }}</p>
                            <p class="lead">Name: {{ $details->firstname }} {{ $details->lastname }}</p>
                            <p class="lead">Username: {{ $details->username }}</p>
                            <p class="lead">E-mail: {{ $details->email }}</p>
                            <p class="lead">Address: {{ $details->user_address }}</p>
                            <p class="lead">Contact: {{ $details->user_contact }}</p>
                        </div>
                        <div class="col border">
                            <div class="row">
                                <h5 class="col text-left lead"><b>Car</b></h5>
                            </div>
                            <hr class="my-4">
                            <p class="lead">ID: {{ $details->car_id }}</p>
                            <p class="lead">Model: {{ $details->model }}</p>
                            <p class="lead">Brand: {{ $details->brand }}</p>
                            <p class="lead">Model year: {{ $details->model_year }}</p>
                            <p class="lead">Plate Number: {{ $details->plate_number }}</p>
                            <p class="lead">Capacity: {{ $details->people_no }}</p>
                            <p class="lead">Color: {{ $details->color }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
