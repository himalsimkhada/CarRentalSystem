@extends('layouts.app')

@section('title', 'Car Lists')

@section('content')
    <div class="row h-100 content flex-fill m-0">
        <div class="col-3 sidebar">
            <form action="{{ route('listing') }}" method="post" class="p-5 needs-validation" novalidate>
                @csrf
                <p class="h1">Search For Rental Car</p>
                <div class="form-group">
                    <div class="form-group">
                        <label class="form-label">Pick Up Date</label>
                        <input type="date" name="picking-date" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" class="form-control" required>
                        <div class="invalid-feedback">
                            Please input picking date.
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Drop Off Date</label>
                        <input type="date" name="dropping-date" id="" class="form-control" min="{{ date('Y-m-d') }}" required>
                        <div class="invalid-feedback">
                            Please input dropping date.
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Pick up Location</label>
                        <select name="picklocation" class="custom-select" required>
                            <option value="" disabled selected>Locations</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location->location }}">{{ $location->location }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Location is required for searching.
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Type</label>
                        <select class="custom-select" name="booking-type" id="" required>
                            <option value="" disabled selected>Choose</option>
                            @foreach ($booking_type as $datas)
                                <option value="{{ $datas->name }}">{{ $datas->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Please select booking type.
                        </div>
                    </div>
                </div>
                <div class="pt-4">
                    <button type="submit" class="form-control btn btn-outline-success btn-lg btn-block">Search<span
                            class="material-icons align-middle">
                            search
                        </span></button>
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
        <div class="col-9">
            <p class="text-center h1">List of the available rental cars</p>
            <div class="row cont-row">
                @foreach ($list as $lists)
                    <div class="col-sm-3 my-5">
                        <div class="card" style="width: 100%; min-height: 100%">
                            <img src="{{ asset('images/car/images/' . $lists->primary_image) }}" class="card-img-top"
                                alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{ $lists->model }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $lists->model_year }}</h6>
                                <p class="card-text" title="{{ $lists->description }}">
                                    {{ substr($lists->description, 0, 50) }}</p>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Brand: {{ $lists->brand }}</li>
                                    <li class="list-group-item">Color: {{ $lists->color }}</li>
                                    <li class="list-group-item">Capacity: {{ $lists->type->people_no }}</li>
                                </ul>
                                <a href="{{ route('car.detail', ['car-id' => $lists->id, 'date' => $pickdate, 'return' => $dropdate, 'type' => $bookingtype, 'location' => $location]) }}"
                                    class="btn btn-primary mt-3">View Deal<span class="material-icons align-middle">
                                        local_offer
                                    </span></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
