@extends('layouts.dashboard')

@section('title', 'Edit Profile')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <p class="text-center h1 title">Add/Edit Credential</p>
            <div class="row">
                <div class="col">
                    @if (auth()->guard('company')->check())
                        @if (Route::is('company.create.credential'))
                            <form action="{{ route('company.store.credential') }}" method="post" enctype="multipart/form-data"
                                class="needs-validation" novalidate>
                            @elseif (Route::is('company.edit.credential'))
                                <form action="{{ route('company.update.credential') }}" method="post"
                                    enctype="multipart/form-data" class="needs-validation" novalidate>
                        @endif
                    @elseif (auth()->check())
                        @if (Route::is('user.create.credential'))
                            <form action="{{ route('user.store.credential') }}" method="post" enctype="multipart/form-data"
                                class="needs-validation" novalidate>
                            @elseif (Route::is('user.edit.credential'))
                                <form action="{{ route('user.update.credential') }}" method="post"
                                    enctype="multipart/form-data" class="needs-validation" novalidate>
                        @endif
                    @endif
                    @csrf
                    <input type="hidden" value="{{ Crypt::encrypt($credential->id) }}" name="id">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Informations</h4>
                            <hr>
                            <div class="form-group">
                                <label class="">Credential Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $credential->name }}"
                                    required>
                            </div>
                            <div class="form-group">
                                <label class="">Credential Number</label>
                                <input type="text" class="form-control" name="reg_number" value="{{ $credential->reg_number }}"
                                    required>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label>File Attachment</label>
                                        <input type="file" name="file" class="form-control" {{ $credential->file ? '' : 'required' }}>
                                    </div>
                                    <div class="col">
                                        <label>Image Attachment</label>
                                        <input type="file" name="image" class="form-control" {{ $credential->image ? '' : 'required' }}>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary float-right">Submit</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
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
