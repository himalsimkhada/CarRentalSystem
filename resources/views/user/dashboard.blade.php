@extends('layouts.dashboard')

@section('title', 'User')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            @foreach ($user_detail as $detail)
                <p class="text-center h1 title">Welcome, {{ $detail->username }}</p>
                <hr>
                <div class="row">
                    <div class="col-3">
                        <img src="{{ asset('/images/profile_images/' . $detail->profile_photo) }}" alt=""
                            class="img-thumbnail">
                        <small class="form-text text-muted">Profile Picture / Avatar</small>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Basic Informations</h4>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Firstname: <b>{{ $detail->firstname }}</b></li>
                            <li class="list-group-item">Lastname: <b>{{ $detail->lastname }}</b></li>
                            <li class="list-group-item">Date of Birth: <b>{{ $detail->date_of_birth }}</b></li>
                            <li class="list-group-item">Address: <b>{{ $detail->address }}</b></li>
                        </ul>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Privacy Details</h4>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">User ID: <b>{{ $detail->id }}</b></li>
                            <li class="list-group-item">Username: <b>{{ $detail->username }}</b></li>
                            <li class="list-group-item">E-mail: <b>{{ $detail->email }}</b></li>
                            <li class="list-group-item">Contact: <b>{{ $detail->contact }}</b></li>
                        </ul>
                    </div>
                </div>
                <hr>
                <h6 class="border lead text-center text-dark p-3"><b>Credentials</b></h6>
                <div class="row">
                    @foreach ($credentials as $credential)
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Name: {{ $credential->credential_name }}</h4>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Type Number:: {{ $credential->credential_id }}</li>
                                <li class="list-group-item">Get Photo: <a
                                        href="{{ asset('user/credentials/images/' . $credential->image) }}"
                                        class="d-inline-block text-info">Download</a></li>
                                <li class="list-group-item">Get File: <a
                                        href="{{ asset('user/credentials/files/' . $credential->credential_file) }}"
                                        class="d-inline-block text-info">Download</a></li>
                            </ul>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endsection
