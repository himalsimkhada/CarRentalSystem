@extends('layouts.dashboard')

@section('title', 'Notifications')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <p class="text-center title">NOTIFICATIONS</p>
            <div class="card">
                <div class="card-body">
                    @if (auth()->user()->user_type == 3)
                        Reservation Notifications
                        <br>
                        @forelse($notificationsReserved as $notification)
                            <div class="alert alert-primary" role="alert">
                                [{{ $notification->created_at }}] You
                                ({{ $notification->data['email'] }}) have successfully reserved a car.
                                <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                                    Mark as read
                                </a>
                            </div>

                            @if ($loop->last)
                                <a href="#" id="mark-all">
                                    Mark all as read
                                </a>
                            @endif
                        @empty
                            There are no new reservation notifications
                        @endforelse
                        <hr>
                        Payment Notifications
                        <br>
                        @forelse($notificationsPayment as $notification)
                            <div class="alert alert-success" role="alert">
                                [{{ $notification->created_at }}] You
                                ({{ $notification->data['email'] }}) have successfully paid for the reserved car.
                                <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                                    Mark as read
                                </a>
                            </div>

                            @if ($loop->last)
                                <a href="#" id="mark-all">
                                    Mark all as read
                                </a>
                            @endif
                        @empty
                            There are no new payment notifications
                        @endforelse
                        <hr>
                        Partner Request Notifications
                        <br>
                        @forelse($notificationsRequest as $notification)
                            <div class="alert alert-success" role="alert">
                                [{{ $notification->created_at }}] User "{{ $notification->data['firstname'] }}
                                {{ $notification->data['lastname'] }}"
                                ({{ $notification->data['email'] }}) has request to partner his/her company.
                                <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                                    Mark as read
                                </a>
                            </div>
                        @empty
                            There are no new partner request notifications
                        @endforelse
                        <hr>
                        Partner Approved Notifications
                        <br>
                        @forelse($notificationsApproved as $notification)
                            <div class="alert alert-success" role="alert">
                                [{{ $notification->created_at }}] Admin "{{ $notification->data['firstname'] }}
                                {{ $notification->data['lastname'] }}"
                                ({{ $notification->data['email'] }}) has approved the request.
                                <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                                    Mark as read
                                </a>
                            </div>
                        @empty
                            There are no new request approved notifications
                        @endforelse
                        <hr>
                        Partner Approved Notifications
                        <br>
                        @forelse($notificationsApproved as $notification)
                            <div class="alert alert-success" role="alert">
                                [{{ $notification->created_at }}] Admin "{{ $notification->data['firstname'] }}
                                {{ $notification->data['lastname'] }}"
                                ({{ $notification->data['email'] }}) has denied the request.
                                <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                                    Mark as read
                                </a>
                            </div>
                        @empty
                            There are no new request denied notifications
                        @endforelse
                        <hr>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
