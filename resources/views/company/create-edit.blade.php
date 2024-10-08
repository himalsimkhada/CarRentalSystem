@extends('layouts.dashboard')

@section('title', 'Edit Company')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <p class="text-center h1 title">Add/Edit Company</p>
            @if (Route::is('admin.create.company'))
                <form action="{{ route('admin.store.company') }}" method="post" enctype="multipart/form-data"
                    class="needs-validation" novalidate>
                @elseif (Route::is('admin.edit.company'))
                    <form action="{{ route('admin.update.company') }}" method="post" enctype="multipart/form-data"
                        class="needs-validation" novalidate>
                    @elseif (Route::is('company.edit.profile'))
                        <form action="{{ route('company.update.profile') }}" method="post" enctype="multipart/form-data"
                            class="needs-validation" novalidate>
            @endif
            @csrf
            <input type="hidden" name="id" value="{{ Crypt::encrypt($company->id) }}">
            <div class="row">
                <div class="col-3">
                    <div class="card">
                        <img src="{{ !is_null(auth()->guard('company')->user()->logo) &&file_exists(public_path(auth()->guard('company')->user()->logo))? asset(auth()->guard('company')->user()->logo): asset('/images/company/profile_images/default.png') }}"
                            alt=""
                            class="img-thumbnail">
                        <div class="card-body">
                            <input type="file" name="logo" id="" class="form-control">
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
                            <div class="mb-3">
                                <label class="">Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $company['name'] }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description">{{ $company['description'] }}</textarea>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col">
                                        <label class="">Address</label>
                                        <input type="text" class="form-control" name="address"
                                            value="{{ $company['address'] }}">
                                    </div>
                                    <div class="col">
                                        <label class="">Contact</label>
                                        <input type="text" class="form-control" name="contact"
                                            value="{{ $company['contact'] }}">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Registration Number</label>
                                <input type="text" name="registration_number" class="form-control"
                                    value="{{ $company['registration_number'] }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">E-mail</label>
                                <input type="email" name="email" class="form-control" value="{{ $company['email'] }}"
                                    {{ auth()->check() ? '' : 'readonly' }}>
                                <small class="form-text text-muted">Contact admin to change your email
                                    address.</small>
                            </div>
                            <div>
                                <small class="d-inline-block form-text text-muted">Clicking submit will
                                    update your
                                    profile data.</small>
                                <button type="submit" class="d-inline-block btn btn-primary float-end">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
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
