@extends('layouts.dashboard')

@section('title', 'Add cars')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <p class="text-center h1 title">ADD A CAR</p>
            <div class="d-flex align-items-center justify-content-center">
                <form action="{{ route('company.add.car') }}" method="POST" class="w-50 needs-validation" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="form-group">
                        <label for="model">Model Name</label>
                        <input type="text" name="model" id="model" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="model_year">Model Year</label>
                        <input type="text" name="model_year" id="" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="brand">Brand</label>
                        <input type="text" name="brand" id="" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="color">Color</label>
                        <select name="color" id="" class="custom-select" required>
                            <option value="white" style="color: black; background-color: white">White</option>
                            <option value="gray" style="color: white; background-color: gray">Gray</option>
                            <option value="silver" style="color: black; background-color: silver">Silver</option>
                            <option value="red" style="color: black; background-color: red">Red</option>
                            <option value="blue" style="color: black; background-color: blue">Blue</option>
                            <option value="yellow" style="color: black; background-color: yellow">Yellow</option>
                            <option value="green" style="color: white; background-color: green">Green</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="plate_number">Plate Number</label>
                        <input type="text" name="plate_number" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Primary Image</label>
                        <input type="file" name="primary_image" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="booking_type">Booking Type</label>
                        <select name="booking_type_id" id="" class="custom-select" required>
                            <option value="" disabled selected>Select Type</option>
                            @foreach ($lists as $list)
                                <option value="{{ $list->id }}">{{ $list->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gridCheck" name="availability">
                            <label class="form-check-label" for="gridCheck">
                                Availability
                            </label>
                        </div>
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="text-danger">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
