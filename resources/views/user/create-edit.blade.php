@extends('layouts.dashboard')

@section('title', 'Edit Profile')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <p class="text-center h1 title">Edit Profile</p>
            <div class="row">
                <div class="col-3">
                    <div class="card">
                        <img src="{{ file_exists(public_path($user->profile_photo)) ? asset($user->profile_photo) : asset('/images/profile_images/default.png') }}"
                            alt=""
                            class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}">
                        <div class="card-body">
                            <form action="{{ route('user.update.picture') }}" enctype="multipart/form-data" method="post"
                                class="needs-validation" novalidate>
                                @csrf
                                <input type="hidden" value="{{ Crypt::encrypt($user->id) }}" name="id">
                                <div class="mb-3">
                                    <input type="file" class="form-control " name="profile_photo" required>
                                    <div class="invalid-tooltip">
                                        Please provide a profile image.
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Change
                                    Profile</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <form action="{{ route('user.update.profile') }}" method="post" enctype="multipart/form-data"
                        class="needs-validation" novalidate>
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Informations</h4>
                                <hr>
                                <div class="mb-3">
                                    <input type="hidden" value="{{ Crypt::encrypt($user->id) }}" name="id">
                                    <div class="row">
                                        <div class="col">
                                            <label class="">Firstname</label>
                                            <input type="text" class="form-control" name="firstname"
                                                value="{{ $user->firstname }}" required>
                                        </div>
                                        <div class="col">
                                            <label class="">Lastname</label>
                                            <input type="text" class="form-control" name="lastname"
                                                value="{{ $user->lastname }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Date of birth</label>
                                    <input type="date" name="date_of_birth" class="form-control" disabled
                                        value="{{ $user->date_of_birth }}" required readonly>
                                    <small class="form-text text-muted">Contact admin to change your date of
                                        birth.</small>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col">
                                            <label class="">Address</label>
                                            <input type="text" class="form-control" name="address"
                                                value="{{ $user->address }}" required>
                                        </div>
                                        <div class="col">
                                            <label class="">Contact</label>
                                            <input type="text" class="form-control" name="contact"
                                                value="{{ $user->contact }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control" name="username"
                                        value="{{ $user->username }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">E-mail</label>
                                    <input type="email" name="email" class="form-control" value="{{ $user->email }}"
                                        required readonly>
                                    <small class="form-text text-muted">Contact admin to change your email
                                        address.</small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-target="#changePass">Change Password
                                        <span class="material-icons align-middle">
                                            lock
                                        </span>
                                    </button>
                                </div>
                                <button type="submit" class="btn btn-primary float-end">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- @endforeach --}}
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="text-danger">
                        {{ $error }}
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
