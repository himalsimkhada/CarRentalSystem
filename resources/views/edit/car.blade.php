@extends('layouts.dashboard')

@section('title', 'Edit Car')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            @foreach ($cars as $detail)
                <h3>Edit</h3>
                <div class="">
                    <form action="{{ route('company.edit.car', ['car-id' => $detail->id]) }}" method="POST"
                        class="m-2 px-3 py-1 border w-50 needs-validation" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="form-group">
                            <label for="model">Model Name</label>
                            <input type="text" name="model" id="model" value="{{ $detail->model }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control">{{ $detail->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="model_year">Model Year</label>
                            <input type="text" name="model_year" id="" class="form-control"
                                value="{{ $detail->model_year }}">
                        </div>
                        <div class="form-group">
                            <label for="brand">Brand</label>
                            <input type="text" name="brand" id="" class="form-control" value="{{ $detail->brand }}">
                        </div>
                        <div class="form-group">
                            <label for="color">Color</label>
                            <select name="color" id="" class="form-control">
                                <option value="{{ $detail->color }}" selected>{{ $detail->color }}</option>
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
                            <input type="text" name="plate_number" class="form-control"
                                value="{{ $detail->plate_number }}">
                        </div>
                        <div class="form-group">
                            <label>Primary Image</label>
                            <input type="file" name="primary_image" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="booking_type">Booking Type</label>
                            <select name="bookingtype_id" id="" class="custom-select" required>
                            <option value="{{ $detail->booking_type_id }}" selected>Current</option>
                                @foreach ($types as $list)
                                    <option value="{{ $list->id }}">{{ $list->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="availability" id="" <?php if ($detail->availability == 1) {echo 'checked';}?> >
                                    Availability
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
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
