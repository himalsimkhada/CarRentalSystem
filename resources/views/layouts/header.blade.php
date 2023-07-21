@php
    $getDetails = DB::table('booking_types')->get();
@endphp

<div>
    <div class="container">
        <div class="float-right"><span>Email: <a href="#">onlinecar@rental.com</a></span></div>
        <div class="row">
            <div class="col-12">
                <nav class="navbar navbar-expand-md navbar-light">
                    <a class="navbar-brand" href="{{ route('index') }}" target="_blank"><img
                            src="{{ asset('images/system/logo/logo1.png') }}"></a>
                    <a class="navbar-brand" href="{{ route('index') }}">Online Car Rental</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto py-4 py-md-0">
                            <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4 {{ request()->is('/') ? 'active' : '' }}">
                                <a href="{{ route('index') }}" class="nav-link">Home</a>
                            </li>
                            <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4 {{ request()->is('car*') ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                                    aria-haspopup="true" aria-expanded="false">Cars <i
                                        class="fas fa-caret-down"></i></a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('cars.list') }}">View All</a>
                                    @foreach ($getDetails as $detail)
                                        <a class="dropdown-item"
                                            href="{{ route('car.category', ['type_id' => $detail->id]) }}">{{ $detail->name }}</a>
                                    @endforeach
                                </div>
                            </li>
                            <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                                <a class="nav-link" href="{{ route('faqs') }}">FAQS</a>
                            </li>
                            <li
                                class="nav-item pl-4 pl-md-0 ml-0 ml-md-4 {{ request()->is('contactus') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('contactus') }}">Contact Us</a>
                            </li>
                            @if (!auth()->guard('company')->check() && !auth()->check())
                                <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
                                        role="button" aria-haspopup="true" aria-expanded="false">Login / Register <span
                                            class="material-icons align-middle">
                                            expand_more
                                        </span></a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('login') }}">Login</a>
                                        <a class="dropdown-item" href="{{ route('company.login') }}">Company Login</a>
                                        <a class="dropdown-item" href="{{ route('register') }}">Register</a>
                                    </div>
                                </li>
                            @else
                                <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
                                        role="button" aria-haspopup="true" aria-expanded="false"><span
                                            class="material-icons align-middle">
                                            account_circle
                                        </span>
                                        @if (auth()->guard('company')->check())
                                            {{ auth()->guard('company')->name }}
                                        @elseif (auth()->check())
                                            {{ auth()->user()->username }}
                                        @endif
                                        <span class="material-icons align-middle">
                                            arrow_drop_down
                                        </span>
                                        <div class="dropdown-menu">
                                            @if (auth()->check() && auth()->user()->user_type == 1)
                                                <a href="{{ route('admin.dashboard') }}" class="dropdown-item">Admin
                                                    Dashboard</a>
                                            @elseif (auth()->guard('company')->check())
                                                <a href="{{ route('company.dashboard') }}"
                                                    class="dropdown-item">Company
                                                    Dashboard</a>
                                            @elseif (auth()->check() && auth()->user()->user_type == 3 )
                                                <a href="{{ route('user.dashboard') }}" class="dropdown-item">User
                                                    Dashboard</a>
                                                <a href="{{ route('req.partnership') }}" class="dropdown-item">Request
                                                    Partner</a>
                                            @endif
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}<span
                                                    class="material-icons align-middle float-right">
                                                    logout
                                                </span>
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
<hr>
