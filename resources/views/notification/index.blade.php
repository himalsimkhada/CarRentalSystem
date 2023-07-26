@extends('layouts.dashboard')

@section('title', 'Notifications')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <p class="text-center title">Notifications</p>
            <div class="card">
                <div class="card-body">
                    Notifications
                    <br>
                    @forelse($notifications as $notification)
                        @if ($notification->type == 'App\Notifications\BookingNotification')
                            <div class="alert alert-info" role="alert">
                                [{{ $notification->created_at }}] <b>
                                    {{ $notification->data['email'] }} </b>
                                have successfully reserved a car.
                                <a href="#" class="float-end mark-as-read" data-id="{{ $notification->id }}">
                                    Mark as read
                                </a>
                            </div>
                        @elseif ($notification->type == 'App\Notifications\RegistrationNotification')
                            <div class="alert alert-info" role="alert">
                                [{{ $notification->created_at }}]
                                <b>{{ $notification->data['email'] }} </b> have registered into the system.
                                <a href="#" class="float-end mark-as-read" data-id="{{ $notification->id }}">
                                    Mark as read
                                </a>
                            </div>
                        @elseif ($notification->type == 'App\Notifications\PaymentNotification')
                            <div class="alert alert-success" role="alert">
                                [{{ $notification->created_at }}]
                                <b>{{ $notification->data['email'] }} </b> has paid for the booking .
                                <a href="#" class="float-end mark-as-read" data-id="{{ $notification->id }}">
                                    Mark as read
                                </a>
                            </div>
                        @endif
                        @if ($loop->last)
                            <a href="#" id="mark-all">
                                Mark all as read
                            </a>
                        @endif
                    @empty
                        There are no new notifications
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
