@extends('layouts.dashboard')

@section('title', 'User')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <p class="text-center h1 title">Welcome, {{ $user->username }}</p>
            <hr>
            <div class="row">
                <div class="col-3">
                    <img src="{{ file_exists(asset('/images/profile_images/' . $user->profile_photo)) ? asset('/images/profile_images/' . $user->profile_photo) : asset('/images/profile_images/default.png') }}"
                        alt="" class="img-thumbnail">
                    <small class="form-text text-muted">Profile Picture / Avatar</small>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Basic Information</h4>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Firstname: <b>{{ $user->firstname }}</b></li>
                        <li class="list-group-item">Lastname: <b>{{ $user->lastname }}</b></li>
                        <li class="list-group-item">Date of Birth: <b>{{ $user->date_of_birth }}</b></li>
                        <li class="list-group-item">Address: <b>{{ $user->address }}</b></li>
                    </ul>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Private Information</h4>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">User ID: <b>{{ $user->id }}</b></li>
                        <li class="list-group-item">Username: <b>{{ $user->username }}</b></li>
                        <li class="list-group-item">E-mail: <b>{{ $user->email }}</b></li>
                        <li class="list-group-item">Contact: <b>{{ $user->contact }}</b></li>
                    </ul>
                </div>
            </div>
            <hr>
            <h6 class="border lead text-center text-dark p-3"><b>Credentials</b></h6>
            <div class="row">
                @foreach ($credentials as $credential)
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Name: {{ $credential->name }}</h4>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Type Number:: {{ $credential->reg_number }}</li>
                            <li class="list-group-item">Get Photo: <a
                                    href="{{ asset('user/credentials/images/' . $credential->image) }}"
                                    class="d-inline-block text-info">Download</a></li>
                            <li class="list-group-item">Get File: <a
                                    href="{{ asset('user/credentials/files/' . $credential->file) }}"
                                    class="d-inline-block text-info">Download</a></li>
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
