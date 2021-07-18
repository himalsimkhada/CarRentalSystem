@extends('layouts.dashboard')

@section('title', 'Notifications')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <p class="text-center title">NOTIFICATIONS</p>
            <div class="card">
                <div class="card-body">
                    @if (auth()->user()->user_type == 2)
                        Reservation Notifications
                        <br>
                        @forelse($notificationsReserved as $notification)
                            <div class="alert alert-primary" role="alert">
                                [{{ $notification->created_at }}] User "{{ $notification->data['firstname'] }}
                                {{ $notification->data['lastname'] }}"
                                ({{ $notification->data['email'] }}) has just reserved a car.
                                <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                                    Mark as read
                                </a>
                            </div>
                        @empty
                            There are no new reservation notifications
                        @endforelse
                        <hr>
                        Payment Notifications
                        <br>
                        @forelse($notificationsPayment as $notification)
                            <div class="alert alert-success" role="alert">
                                [{{ $notification->created_at }}] User "{{ $notification->data['firstname'] }}
                                {{ $notification->data['lastname'] }}"
                                ({{ $notification->data['email'] }}) has paid for the reserved car.
                                <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                                    Mark as read
                                </a>
                            </div>
                        @empty
                            There are no new payment notifications
                        @endforelse
                        <hr>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
