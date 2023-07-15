@extends('layouts.dashboard')

@section('title', 'Notifications')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <p class="text-center title">NOTIFICATIONS</p>
            <div class="card">
                <div class="card-body">
                    @if (auth()->user()->user_type == 1)
                        Notifications
                        <br>
                        @forelse($notifications as $notification)
                            @if ($notification->type == 'App\Notifications\NewReservationNotification')
                                <div class="alert alert-info" role="alert">
                                    [{{ $notification->created_at }}] You
                                    ({{ $notification->data['email'] }})
                                    have successfully reserved a car.
                                    <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                                        Mark as read
                                    </a>
                                </div>
                            @elseif ($notification->type == 'App\Notifications\NewUserRegisteredNotification')
                                <div class="alert alert-info" role="alert">
                                    [{{ $notification->created_at }}] You
                                    ({{ $notification->data['email'] }}) have successfully paid for the reserved car.
                                    <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                                        Mark as read
                                    </a>
                                </div>
                            @elseif ($notification->type == 'App\Notifications\PaymentNotification')
                                <div class="alert alert-success" role="alert">
                                    [{{ $notification->created_at }}] User "{{ $notification->data['firstname'] }}
                                    {{ $notification->data['lastname'] }}"
                                    ({{ $notification->data['email'] }}) has request to partner his/her company.
                                    <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                                        Mark as read
                                    </a>
                                </div>
                            @elseif ($notification->type == 'App\Notifications\NewPartnerReqNotification')
                                <div class="alert alert-primary" role="alert">
                                    [{{ $notification->created_at }}] Admin "{{ $notification->data['firstname'] }}
                                    {{ $notification->data['lastname'] }}"
                                    ({{ $notification->data['email'] }}) has denied the request.
                                    <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                                        Mark as read
                                    </a>
                                </div>
                            @elseif ($notification->type == 'App\Notifications\NewPartnerApprovedNotification')
                                <div class="alert alert-success" role="alert">
                                    [{{ $notification->created_at }}] Admin "{{ $notification->data['firstname'] }}
                                    {{ $notification->data['lastname'] }}"
                                    ({{ $notification->data['email'] }}) has denied the request.
                                    <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                                        Mark as read
                                    </a>
                                </div>
                            @elseif ($notification->type == 'App\Notifications\NewPartnerDeniedNotification')
                                <div class="alert alert-danger" role="alert">
                                    [{{ $notification->created_at }}] Admin "{{ $notification->data['firstname'] }}
                                    {{ $notification->data['lastname'] }}"
                                    ({{ $notification->data['email'] }}) has denied the request.
                                    <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
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
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
