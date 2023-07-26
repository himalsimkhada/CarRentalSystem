@extends('layouts.app')

@section('title', 'Homepage')

@section('content')
    <div class="d-flex align-items-center justify-content-center">
        <form action="{{ route('listing') }}" method="get" class="border rounded p-5 index-form needs-validation"
            novalidate>
            @csrf
            <p class="h2 font-weight-bold">Search For Rental Car</p>
            <div class="mb-3">
                <label class="form-label">Pick Up Date</label>
                <input type="date" name="picking-date" class="form-control" value="{{ date('Y-m-d') }}"
                    min="{{ date('Y-m-d') }}" required>
                <div class="invalid-feedback">
                    Please input picking date.
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Drop Off Date</label>
                <input type="date" name="dropping-date" min="{{ date('Y-m-d') }}" class="form-control" required>
                <div class="invalid-feedback">
                    Please input dropping date.
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Pick up Location</label>
                <select name="picklocation" class="form-select" required>
                    <option value="" disabled selected>Locations</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->name }}">{{ $location->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Booking Type</label>
                <select class="form-select" name="booking-type" required>
                    <option value="" disabled selected>Choose</option>
                    @foreach ($data as $datas)
                        <option value="{{ $datas->name }}">{{ $datas->name }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                    Please select booking type.
                </div>
            </div>
            <div class="pt-4">
                <button type="submit" class="form-control btn btn-outline-success btn-lg">Search
                    <span class="material-icons align-middle">
                        search
                    </span></button>
            </div>
        </form>
    </div>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="text-danger">
                {{ $error }}
            </div>
        @endforeach
    @endif

    <div class="row p-0 m-0">
        <div class="col col-12">
            <p class="text-center h1 mt-5">Current deals</p>
            <div class="row row-cols-1 row-cols-md-4 g-4 cont-row">
                @foreach ($deals as $list)
                    <div class="col h-100">
                        <div class="card" style="width: 100%; min-height: 100%">
                            <img src="{{ file_exists(asset('images/car/images/' . $list->primary_image)) ? asset('images/car/images/' . $list->primary_image) : asset('images/car/images/default.png') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{ $list->model }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $list->model_year }}</h6>
                                <p class="card-text" title="{{ $list->description }}">
                                    {{ substr('Hover here for description', 0, 30) }}</p>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Brand: {{ $list->brand }}</li>
                                    <li class="list-group-item">Color: {{ $list->color }}</li>
                                    <li class="list-group-item">Capacity: {{ $list->bookingType->people_no }}</li>
                                    <li class="list-group-item text-success">Cost(per day): ${{ $list->bookingType->cost }}</li>
                                </ul>
                                <a href="{{ route('car.detail', ['car-id' => $list->id]) }}"
                                    class="btn btn-primary mt-3">View
                                    Deal <span class="material-icons align-middle">
                                        local_offer
                                    </span></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    {{-- popular --}}
    <div class="row p-0 m-0">
        <div class="col col-12">
            <p class="text-center h1 mt-5">Popular Deals</p>
            <div class="row cont-row">
                @foreach ($pop_deals as $list)
                    <div class="col-sm-3 my-5">
                        <div class="card" style="width: 100%; min-height: 100%">
                            <img src="{{ file_exists(asset('images/car/images/' . $list->primary_image)) ? asset('images/car/images/' . $list->primary_image) : asset('images/car/images/default.png') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{ $list->model }} -- Booked({{ $list->count }})</h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $list->model_year }}</h6>
                                <p class="card-text" title="{{ $list->description }}">
                                    {{ substr('Hover here for description', 0, 30) }}</p>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Brand: {{ $list->brand }}</li>
                                    <li class="list-group-item">Color: {{ $list->color }}</li>
                                    <li class="list-group-item">Capacity: {{ $list->bookingType->people_no }}</li>
                                    <li class="list-group-item text-success">Cost(per day): ${{ $list->bookingType->cost }}</li>
                                </ul>
                                <a href="{{ route('car.detail', ['car-id' => $list->id]) }}"
                                    class="btn btn-primary mt-3">View
                                    Deal <span class="material-icons align-middle">
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
