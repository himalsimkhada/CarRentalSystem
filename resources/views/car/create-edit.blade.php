@extends('layouts.dashboard')

@section('title', 'Edit Company')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <p class="text-center h1 title">Add/Edit Car</p>
            @if (Route::is('company.create.car'))
                <form action="{{ route('company.store.car') }}" method="post" enctype="multipart/form-data"
                    class="needs-validation" novalidate>
                @elseif (Route::is('company.edit.car'))
                <form action="{{ route('company.update.car') }}" method="post" enctype="multipart/form-data"
                class="needs-validation" novalidate>
            @endif
            @csrf
            <input type="text" value="{{ Crypt::encrypt($car->id) }}" name="id" readonly hidden>
            <div class="row">
                <div class="col-3">
                    <div class="card">
                        <img src="{{ file_exists(public_path($car->primary_image)) ? asset($car->primary_image) : asset('/images/car/images/default.png') }}"
                            alt=""
                            class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}">
                        <div class="card-body">
                            <input type="file" name="primary_image" id="" class="form-control">
                            <div class="invalid-tooltip">
                                Please provide a primary image for car.
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
                                <div class="row">
                                    <div class="col">
                                        <label class="">Model</label>
                                        <input type="text" class="form-control" name="model"
                                            value="{{ $car->model }}">
                                    </div>
                                    <div class="col">
                                        <label class="">Model Year</label>
                                        <input type="text" class="form-control" name="model_year"
                                            value="{{ $car->model_year }}">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description">{{ $car->description }}</textarea>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col">
                                        <label class="">Brand</label>
                                        <input type="text" class="form-control" name="brand"
                                            value="{{ $car->brand }}">
                                    </div>
                                    <div class="col">
                                        <label class="">Plate Number</label>
                                        <input type="text" class="form-control" name="plate_number"
                                            value="{{ $car->plate_number }}">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col">
                                        <label class="">Booking Type</label>
                                        <select class="form-select" name="booking_type_id" id="" required>
                                            <option value="{{ $car->bookingType ? $car->bookingType->id : '' }}" hidden selected>
                                                {{ $car->bookingType ? $car->bookingType->name : 'Select' }}
                                            </option>
                                            @foreach ($types as $type)
                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="">Color</label>
                                        <input type="text" class="form-control" name="color"
                                            value="{{ $car->color }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col form-check">
                                <input type="checkbox" name="availability" class="form-check-input"
                                    value="{{ $car->availability }}" {{ $car->availability == 1 ? 'checked' : '' }}>
                                <label class="form-check-label">Availability</label>
                            </div>
                            <div>
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
