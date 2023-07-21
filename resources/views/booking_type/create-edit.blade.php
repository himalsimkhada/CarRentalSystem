@extends('layouts.dashboard')

@section('title', 'Edit Profile')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <p class="text-center h1 title">Add Booking Type</p>
            <div class="row">
                <div class="col">
                    @if (Route::is('admin.create.type'))
                        <form action="{{ route('admin.store.type') }}" method="post" enctype="multipart/form-data"
                            class="needs-validation" novalidate>
                        @elseif (Route::is('admin.edit.type'))
                            <form action="{{ route('admin.update.type') }}" method="post" enctype="multipart/form-data"
                                class="needs-validation" novalidate>
                    @endif
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Informations</h4>
                            <hr>
                            <div class="form-group">
                                <input type="hidden" value="{{ Crypt::encrypt($type->id) }}" name="id">
                                <label class="">Booking Type Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $type->name }}"
                                    required>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label>Number of Luggage</label>
                                        <input type="text" name="luggage_no" class="form-control"
                                            value="{{ $type->luggage_no }}" required>
                                    </div>
                                    <div class="col">
                                        <label>Number of People</label>
                                        <input type="text" name="people_no" class="form-control"
                                            value="{{ $type->people_no }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label>Cost (per day)</label>
                                        <input type="text" name="cost" class="form-control"
                                            value="{{ $type->cost }}" required>
                                    </div>
                                    <div class="col">
                                        <label>Late Fee</label>
                                        <input type="text" name="late_fee" class="form-control"
                                            value="{{ $type->late_fee }}" required>
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
