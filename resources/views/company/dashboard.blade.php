@extends('layouts.dashboard')

@section('title', 'Company')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <p class="text-center h1 title">COMPANY DASHBOARD</p>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <span class="material-icons" style="font-size: 48px">
                                            directions_car
                                        </span>
                                    </div>
                                    <div class="media-body text-right">
                                        <h3>{{ $count_cars }}</h3>
                                        <span>Cars</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <span class="material-icons" style="font-size: 48px">
                                            group
                                        </span>
                                    </div>
                                    <div class="media-body text-right">
                                        <h3>{{ $count_users }}</h3>
                                        <span>Customers</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <span class="material-icons" style="font-size: 48px">
                                            book_online
                                        </span>
                                    </div>
                                    <div class="media-body text-right">
                                        <h3>{{ $count_reservations }}</h3>
                                        <span>Reservation</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <span class="material-icons" style="font-size: 48px">
                                            book_online
                                        </span>
                                    </div>
                                    <div class="media-body text-right">
                                        <h3>{{ $count_today }}</h3>
                                        <span>Today's Reservation</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
