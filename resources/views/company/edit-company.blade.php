@extends('layouts.dashboard')

@section('title', 'Edit Company')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <p class="text-center h1 title">EDIT COMPANY</p>
            @foreach ($details as $detail)
                <form action="{{ route('company.profile.edited') }}" method="post" enctype="multipart/form-data"
                    class="needs-validation" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-3">
                            <div class="card">
                                <img src="{{ asset('/images/company/profile_images/' . $detail['logo']) }}" alt=""
                                    class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}">
                                <div class="card-body">
                                    <input type="file" name="logo" id="" class="border-0 form-control" required>
                                    <div class="invalid-tooltip">
                                        Please provide a Company Logo.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Informations</h4>
                                    <hr>
                                    <div class="form-group">
                                        <label class="">Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ $detail['name'] }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control"
                                            name="description">{{ $detail['description'] }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col">
                                                <label class="">Address</label>
                                                <input type="text" class="form-control" name="address"
                                                    value="{{ $detail['address'] }}">
                                            </div>
                                            <div class="col">
                                                <label class="">Contact</label>
                                                <input type="text" class="form-control" name="contact"
                                                    value="{{ $detail['contact'] }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Registration Number</label>
                                        <input type="text" name="registration_number" class="form-control"
                                            value="{{ $detail['registration_number'] }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Owner</label>
                                        <input type="text" class="form-control" name="" readonly
                                            value="{{ auth()->user()->username }}">
                                        <small class="form-text text-muted">Contact admin to change details of the
                                            profile.</small>
                                    </div>
                                    <div class="form-group">
                                        <label>E-mail</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ $detail['email'] }}" readonly>
                                        <small class="form-text text-muted">Contact admin to change your email
                                            address.</small>
                                    </div>
                                    <div>
                                        <small class="d-inline-block form-text text-muted">Clicking submit will
                                            update your
                                            profile data.</small>
                                        <button type="submit"
                                            class="d-inline-block btn btn-primary float-right">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endforeach
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
