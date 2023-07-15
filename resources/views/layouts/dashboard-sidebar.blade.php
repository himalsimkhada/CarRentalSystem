@if (Auth::check())
    @if (Auth::user()->user_type == 1)
        <div class="bg-dark" id="sidebar-dashboard">
            <div class="sidebar-header">
                <p class="text-uppercase text-center">Online Car Rental System</p>
            </div>

            <ul class="list-unstyled components">
                <div class="text-center m-2">
                    <img src="{{ asset('images/system/logo/logo1.png') }}" alt="" class="">
                    <p class="welcome-user">Admin Dashboard</p>
                </div>
                <li>
                    <a href="{{ route('admin.dashboard') }}">Dashboard <span
                            class="material-icons align-middle float-right">
                            dashboard
                        </span></a>
                </li>
                <li>
                    <a href="{{ route('index') }}">Homepage <span class="material-icons align-middle float-right">
                            home
                        </span></a>
                </li>
                <li>
                    <a href="{{ route('admin.notification') }}">Notification<span
                            class="badge badge-primary">{{ auth()->user()->unreadNotifications()->count() }}</span><span
                            class="material-icons align-middle float-right">
                            notifications
                        </span></a>
                </li>
                <li>
                    <a href="{{ route('admin.messages') }}">Messages</a>
                </li>
                <li>
                    <a href="#users" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Entities</a>
                    <ul class="collapse list-unstyled" id="users">
                        <li>
                            <a href="{{ route('admin.car.list') }}">Cars<span
                                    class="material-icons align-middle float-right">
                                    directions_car
                                </span></a>
                        </li>
                        <li>
                            <a href="{{ route('admin.company.list') }}">Companies<span
                                    class="material-icons align-middle float-right">
                                    business
                                </span></a>
                        </li>
                        <li>
                            <a href="{{ route('admin.user.list') }}">Users<span
                                    class="material-icons align-middle float-right">
                                    person
                                </span></a>
                        </li>
                        <li>
                            <a href="{{ route('admin.booking.types') }}">Types<span
                                    class="material-icons align-middle float-right">
                                    format_list_bulleted
                                </span></a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('admin.list.reservations') }}">Reservations<span
                            class="material-icons align-middle float-right">
                            book_online
                        </span></a>
                </li>
                <ul class="list-unstyled dash-butn text-center">
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <div class="btn-group"><button class="logout btn btn-danger text-left"
                                    type="submit">Logout</button>
                                <button class="logout btn btn-danger"><span class="material-icons">
                                        logout
                                    </span></button>
                            </div>
                        </form>
                    </li>
                </ul>
            </ul>
        </div>
    @elseif (Auth::user()->user_type == 2)
        <div class="bg-dark" id="sidebar-dashboard">
            <div class="sidebar-header">
                <p class="text-uppercase text-center">Online Car Rental System</p>
            </div>

            <ul class="list-unstyled components">
                <div class="text-center m-2">
                    <img src="{{ file_exists(asset('/images/company/profile_images/' . Auth::user()->company->logo)) ? asset('/images/company/profile_images/' . Auth::user()->company->logo) : asset('/images/company/profile_images/default.png') }}"
                        alt="" class="img-fluid rounded-circle">
                    <p class="welcome-user">Welcome,
                    <p class="username">{{ auth()->user()->company->name }}</p>
                    </p>
                </div>
                <li>
                    <a href="{{ route('company.dashboard') }}">Dashboard<span
                            class="material-icons align-middle float-right">
                            dashboard
                        </span></a>

                </li>
                <li>
                    <a href="{{ route('index') }}">Homepage<span class="material-icons align-middle float-right">
                            home
                        </span></a>
                </li>
                <li>
                    <a href="{{ route('company.notification') }}">Notification<span
                            class="badge badge-primary">{{ auth()->user()->unreadNotifications()->count() }}</span><span
                            class="material-icons align-middle float-right">
                            notifications
                        </span></a>
                </li>
                <li>
                    <a href="{{ route('company.messages') }}">Messages</a>
                </li>
                <li>
                    <a href="{{ route('company.car.list') }}">Cars<span
                            class="material-icons align-middle float-right">
                            directions_car
                        </span></a>
                </li>
                <li>
                    <a href="{{ route('company.list.reservations') }}">Reservations<span
                            class="material-icons align-middle float-right">
                            book_online
                        </span></a>
                </li>
                <li>
                    <a href="#profile" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Profile</a>
                    <ul class="collapse list-unstyled" id="profile">
                        <li>
                            <a href="{{ route('company.profile.edit') }}">Edit Company Details<span
                                    class="material-icons align-middle float-right">
                                    edit
                                </span></a>
                        </li>
                        <li>
                            <a href="{{ route('company.credential') }}">Company Credentials<span
                                    class="material-icons align-middle float-right">
                                    enhanced_encryption
                                </span></a>
                        </li>
                        <li>
                            <a href="{{ route('company.locations') }}">Locations<span
                                    class="material-icons align-middle float-right">
                                    location_on
                                </span></a>
                        </li>
                    </ul>
                </li>
                <ul class="list-unstyled dash-butn text-center">
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <div class="btn-group"><button class="logout btn btn-danger text-left"
                                    type="submit">Logout</button>
                                <button class="logout btn btn-danger"><span class="material-icons">
                                        logout
                                    </span></button>
                            </div>
                        </form>
                    </li>
                </ul>
            </ul>
        </div>
    @elseif (Auth::user()->user_type == 3)
        <div class="bg-dark" id="sidebar-dashboard">
            <div class="sidebar-header">
                <p class="text-uppercase text-center">Online Car Rental System</p>
            </div>

            <ul class="list-unstyled components">
                <div class="text-center m-2">
                    <img src="{{ file_exists(asset('/images/profile_images/' . Auth::user()->profile_photo)) ? asset('/images/profile_images/' . Auth::user()->profile_photo) : asset('/images/profile_images/default.png') }}"
                        alt="" class="img-fluid rounded-circle">
                    <p class="welcome-user">Welcome,
                    <p class="username">{{ Auth::user()->username }}</p>
                    </p>
                </div>
                <li>
                    <a href="{{ route('user.dashboard') }}">Dashboard <span
                            class="material-icons align-middle float-right">
                            dashboard
                        </span></a>
                </li>
                <li>
                    <a href="{{ route('index') }}">Homepage <span class="material-icons align-middle float-right">
                            home
                        </span></a>
                </li>
                <li>
                    <a href="{{ route('user.notification') }}">Notification<span
                            class="badge badge-primary">{{ auth()->user()->unreadNotifications()->count() }}</span><span
                            class="material-icons align-middle float-right">
                            notifications
                        </span></a>
                </li>
                <li>
                    <a href="{{ route('user.reservation') }}">Reservations <span
                            class="material-icons align-middle float-right">
                            book_online
                        </span></a>
                </li>
                <li>
                    <a href="#profile" data-toggle="collapse" aria-expanded="false"
                        class="dropdown-toggle">Profile</a>
                    <ul class="collapse list-unstyled" id="profile">
                        <li>
                            <a href="{{ route('user.profile.edit') }}">Edit Profile <span
                                    class="material-icons align-middle float-right">
                                    edit
                                </span></a>
                        </li>
                        <li>
                            <a href="{{ route('user.credential') }}">Credentials <span
                                    class="material-icons align-middle float-right">
                                    enhanced_encryption
                                </span></a>
                        </li>
                    </ul>
                </li>
                <hr>
                <ul class="list-unstyled dash-butn text-center">
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <div class="btn-group"><button class="logout btn btn-danger text-left"
                                    type="submit">Logout</button>
                                <button class="logout btn btn-danger"><span class="material-icons">
                                        logout
                                    </span></button>
                            </div>
                        </form>
                    </li>
                </ul>
            </ul>
        </div>
    @endif
@endif
<div id="content">
    <button type="button" id="sidebarCollapse" class="navbar-btn border-0 mr-3">
        <span></span>
        <span></span>
        <span></span>
    </button>
</div>
<script>
    $(document).ready(function() {
        $('#sidebarCollapse').on('click', function() {
            $('#sidebar-dashboard').toggleClass('active');
            $(this).toggleClass('active');
        });
    });
</script>
