@php
    $booking_types = DB::table('booking_types')->get();
    if (auth()->check()) {
        $notifications = auth()->user()->unreadNotifications;
    } elseif (
        auth()
            ->guard('company')
            ->check()
    ) {
        $notifications = auth()
            ->guard('company')
            ->user()->unreadNotifications;
    }
@endphp

<link rel="stylesheet" href="{{ asset('css/navbar.css') }}">

<style>
    .notification {
        position: relative;
        color: #212121 !important;
    }

    .notification .notification-icon {
        font-size: 28px;
    }

    .notification-badge {
        position: absolute;
        top: 5px;
        right: -5px;
        display: block;
    }

    .notification-menu {
        width: 400px;
        max-height: 400px;
        overflow: hidden;
        overflow-y: auto;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand align-middle" href="{{ route('index') }}" target="_blank"><img
                src="{{ asset('images/system/logo/logo1.png') }}"></a>
        <a class="navbar-brand" href="{{ route('index') }}">Online Car Rental</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                    <a href="{{ route('index') }}" class="nav-link">Home</a>
                </li>
                <li class="nav-item dropdown {{ request()->is('car*') ? 'active' : '' }}">
                    <a class="nav-link" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                        aria-expanded="false" v-pre>Cars <i class="fas fa-caret-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('cars.list') }}">View All</a></li>
                        @foreach ($booking_types as $booking_type)
                            <li><a class="dropdown-item"
                                    href="{{ route('car.category', ['type_id' => $booking_type->id]) }}">{{ $booking_type->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('faqs') }}">FAQS</a>
                </li>
                <li class="nav-item {{ request()->is('contactus.create') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('contactus.create') }}">Contact Us</a>
                </li>
                @if (!auth()->guard('company')->check() && !auth()->check())
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                            aria-expanded="false" v-pre>Login /
                            Register</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('login') }}">Login</a>
                            <a class="dropdown-item" href="{{ route('company.login') }}">Company
                                Login</a>
                            <a class="dropdown-item" href="{{ route('register') }}">Register</a>
                        </div>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                            aria-expanded="false" v-pre><span class="material-icons align-middle">
                                account_circle
                            </span>
                            @if (auth()->guard('company')->check())
                                {{ auth()->guard('company')->name }}
                            @elseif (auth()->check())
                                {{ auth()->user()->username }}
                            @endif
                        </a>
                        <div class="dropdown-menu">
                            @if (auth()->check() && auth()->user()->user_type == 1)
                                <a href="{{ route('admin.dashboard') }}" class="dropdown-item">Admin
                                    Dashboard</a>
                            @elseif (auth()->guard('company')->check())
                                <a href="{{ route('company.dashboard') }}" class="dropdown-item">Company
                                    Dashboard</a>
                            @elseif (auth()->check() && auth()->user()->user_type == 3)
                                <a href="{{ route('user.dashboard') }}" class="dropdown-item">User
                                    Dashboard</a>
                            @endif
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}<span class="material-icons align-middle float-end">
                                    logout
                                </span>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                        </a>
                    </li>
                @endif
            </ul>
            @if (auth()->guard('company')->check() || auth()->check())
                <div>
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link notification" data-bs-toggle="dropdown" href="#" role="button"
                                aria-haspopup="true" aria-expanded="false"><span
                                    class="material-icons align-middle notification-icon">notifications</span><span
                                    class="badge bg-dark notification-badge">{{ auth()->guard('company')->check()? auth()->guard('company')->user()->unreadNotifications()->count(): (auth()->check()? auth()->user()->unreadNotifications()->count(): '') }}</span></a>

                            <div class="dropdown-menu dropdown-menu-end notification-menu">
                                @forelse($notifications as $notification)
                                    @if ($loop->first)
                                        <a href="#" id="mark-all">
                                            Mark all as read
                                        </a>
                                    @endif
                                    @if ($notification->type == 'App\Notifications\BookingNotification')
                                        <div class="alert alert-info" role="alert">
                                            [{{ $notification->created_at }}] <b>
                                                {{ $notification->data['email'] }} </b>
                                            have successfully reserved a car.
                                            <a href="#" class="float-end mark-as-read"
                                                data-id="{{ $notification->id }}">
                                                Mark as read
                                            </a>
                                        </div>
                                    @elseif ($notification->type == 'App\Notifications\RegistrationNotification')
                                        <div class="alert alert-info" role="alert">
                                            [{{ $notification->created_at }}]
                                            <b>{{ $notification->data['email'] }} </b> have registered into the
                                            system.
                                            <a href="#" class="float-end mark-as-read"
                                                data-id="{{ $notification->id }}">
                                                Mark as read
                                            </a>
                                        </div>
                                    @elseif ($notification->type == 'App\Notifications\PaymentNotification')
                                        <div class="alert alert-success" role="alert">
                                            [{{ $notification->created_at }}]
                                            <b>{{ $notification->data['email'] }} </b> has paid for the booking .
                                            <a href="#" class="float-end mark-as-read"
                                                data-id="{{ $notification->id }}">
                                                Mark as read
                                            </a>
                                        </div>
                                    @endif
                                @empty
                                    There are no new notifications
                                @endforelse
                            </div>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </div>
</nav>
<hr>
