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
                            class="material-icons align-middle float-end">
                            dashboard
                        </span></a>
                </li>
                <li>
                    <a href="{{ route('index') }}">Homepage <span class="material-icons align-middle float-end">
                            home
                        </span></a>
                </li>
                <li>
                    <a href="{{ route('admin.notification') }}">Notification <span
                            class="badge badge-primary notification-badge">{{ auth()->user()->unreadNotifications()->count() }}</span><span
                            class="material-icons align-middle float-end">
                            notifications
                        </span></a>
                </li>
                <li>
                    <a href="{{ route('admin.index.partner-req') }}">Partner Requests</a>
                </li>
                <li>
                    <a href="{{ route('admin.messages') }}">Messages</a>
                </li>
                <li>
                    <a href="#users" data-bs-toggle="collapse" aria-expanded="false"
                        class="dropdown-toggle">Entities</a>
                    <ul class="collapse list-unstyled" id="users">
                        <li>
                            <a href="{{ route('admin.index.car') }}">Cars<span
                                    class="material-icons align-middle float-end">
                                    directions_car
                                </span></a>
                        </li>
                        <li>
                            <a href="{{ route('admin.index.company') }}">Companies<span
                                    class="material-icons align-middle float-end">
                                    business
                                </span></a>
                        </li>
                        <li>
                            <a href="{{ route('admin.user.list') }}">Users<span
                                    class="material-icons align-middle float-end">
                                    person
                                </span></a>
                        </li>
                        <li>
                            <a href="{{ route('admin.list.type') }}">Types<span
                                    class="material-icons align-middle float-end">
                                    format_list_bulleted
                                </span></a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('user.index.booking') }}">Bookings<span
                            class="material-icons align-middle float-end">
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
    @elseif (auth()->guard('company')->check())
        <div class="bg-dark" id="sidebar-dashboard">
            <div class="sidebar-header">
                <p class="text-uppercase text-center">Online Car Rental System</p>
            </div>

            <ul class="list-unstyled components">
                <div class="text-center m-2">
                    <img src="{{ !is_null(auth()->guard('company')->user()->logo) &&file_exists(public_path('/images/company/profile_images/' .auth()->guard('company')->user()->logo))? asset('/images/company/profile_images/' .auth()->guard('company')->user()->logo): asset('/images/company/profile_images/default.png') }}"
                        alt="" class="img-fluid rounded-circle">
                    <p class="welcome-user">Welcome,
                    <p class="username">{{ auth()->guard('company')->user()->name }}</p>
                    </p>
                </div>
                <li>
                    <a href="{{ route('company.dashboard') }}">Dashboard<span
                            class="material-icons align-middle float-end">
                            dashboard
                        </span></a>

                </li>
                <li>
                    <a href="{{ route('index') }}">Homepage<span class="material-icons align-middle float-end">
                            home
                        </span></a>
                </li>
                <li>
                    <a href="{{ route('company.notification') }}">Notification <span
                            class="badge badge-primary notification-badge">{{ auth()->guard('company')->user()->unreadNotifications()->count() }}</span><span
                            class="material-icons align-middle float-end">
                            notifications
                        </span></a>
                </li>
                <li>
                    <a href="{{ route('company.messages') }}">Messages</a>
                </li>
                <li>
                    <a href="{{ route('company.index.car') }}">Cars<span class="material-icons align-middle float-end">
                            directions_car
                        </span></a>
                </li>
                <li>
                    <a href="{{ route('company.index.booking') }}">Bookings<span
                            class="material-icons align-middle float-end">
                            book_online
                        </span></a>
                </li>
                <li>
                    <a href="#profile" data-bs-toggle="collapse" aria-expanded="false"
                        class="dropdown-toggle">Profile</a>
                    <ul class="collapse list-unstyled" id="profile">
                        <li>
                            <a
                                href="{{ route('company.edit.profile', ['id' => Crypt::encrypt(auth()->guard('company')->user()->id)]) }}">Edit
                                Company Details<span class="material-icons align-middle float-end">
                                    edit
                                </span></a>
                        </li>
                        <li>
                            <a href="{{ route('company.index.credential') }}">Company Credentials<span
                                    class="material-icons align-middle float-end">
                                    enhanced_encryption
                                </span></a>
                        </li>
                        <li>
                            <a href="{{ route('company.index.location') }}">Locations<span
                                    class="material-icons align-middle float-end">
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
                    <img src="{{ !is_null(auth()->user()->profile_photo) && file_exists(public_path('/images/profile_images/' . auth()->user()->profile_photo)) ? asset('/images/profile_images/' . auth()->user()->profile_photo) : asset('/images/profile_images/default.png') }}"
                        alt="" class="img-fluid rounded-circle">
                    <p class="welcome-user">Welcome,
                    <p class="username">{{ auth()->user()->username }}</p>
                    </p>
                </div>
                <li>
                    <a href="{{ route('user.dashboard') }}">Dashboard <span
                            class="material-icons align-middle float-end">
                            dashboard
                        </span></a>
                </li>
                <li>
                    <a href="{{ route('index') }}">Homepage <span class="material-icons align-middle float-end">
                            home
                        </span></a>
                </li>
                <li>
                    <a href="{{ route('user.notification') }}">Notification <span
                            class="badge badge-primary notification-badge">{{ auth()->user()->unreadNotifications()->count() }}</span><span
                            class="material-icons align-middle float-end">
                            notifications
                        </span></a>
                </li>
                <li>
                    <a href="{{ route('user.index.booking') }}">Booking<span
                            class="material-icons align-middle float-end">
                            book_online
                        </span></a>
                </li>
                <li>
                    <a href="#profile" data-bs-toggle="collapse" aria-expanded="false"
                        class="dropdown-toggle">Profile</a>
                    <ul class="collapse list-unstyled" id="profile">
                        <li>
                            <a href="{{ route('user.edit.profile', ['id' => Crypt::encrypt(auth()->user()->id)]) }}">Edit
                                Profile <span class="material-icons align-middle float-end">
                                    edit
                                </span></a>
                        </li>
                        <li>
                            <a href="{{ route('user.index.credential') }}">Credentials <span
                                    class="material-icons align-middle float-end">
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
<div id="hamburger">
    <button type="button" id="sidebarCollapse" class="navbar-btn border-0">
        <span></span>
        <span></span>
        <span></span>
    </button>
</div>
<script type="module">
    $(document).ready(function() {
        $('#sidebarCollapse').on('click', function() {
            $('#sidebar-dashboard').toggleClass('active');
            $(this).toggleClass('active');
        });
    });
</script>
