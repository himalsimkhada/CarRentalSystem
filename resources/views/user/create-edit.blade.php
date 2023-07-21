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
                        <img src="{{ file_exists(public_path('/images/profile_images/' . $user->profile_photo)) ? asset('/images/profile_images/' . $user->profile_photo) : asset('/images/profile_images/default.png') }}"
                            alt=""
                            class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}">
                        <div class="card-body">
                            <form action="{{ route('user.update.picture') }}" enctype="multipart/form-data"
                                method="post" class="needs-validation" novalidate>
                                @csrf
                                <input type="hidden" value="{{ Crypt::encrypt($user->id) }}" name="id">
                                <div class="form-group">
                                    <input type="file" class="form-control border-0" name="profile_photo" required>
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
                                <div class="form-group">
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
                                <div class="form-group">
                                    <label>Date of birth</label>
                                    <input type="date" name="date_of_birth" class="form-control" disabled
                                        value="{{ $user->date_of_birth }}" required readonly>
                                    <small class="form-text text-muted">Contact admin to change your date of
                                        birth.</small>
                                </div>
                                <div class="form-group">
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
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="username" value="{{ $user->username }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label>E-mail</label>
                                    <input type="email" name="email" class="form-control" value="{{ $user->email }}"
                                        required readonly>
                                    <small class="form-text text-muted">Contact admin to change your email
                                        address.</small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Password</label>
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#changePass">Change Password
                                        <span class="material-icons align-middle">
                                            lock
                                        </span>
                                    </button>
                                </div>
                                <button type="submit" class="btn btn-primary float-right">Submit</button>
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
            <div class="modal fade" id="changePass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('password.change') }}" method="post" class="needs-validation"
                            novalidate>
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Old Password</label>
                                    <input type="password" name="old_password" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" minlength="8" class="form-control" required>
                                    <div class="invalid-feedback">
                                        Must be 8 characters
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
