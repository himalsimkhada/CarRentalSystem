@extends('layouts.app')

@section('title', 'Car Lists')

@section('content')
    <ul class="list-inline text-right">
        <li class="list-inline-item">
            <div class="dropdown open drop-left">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Sort by
                </button>
                <div class="dropdown-menu" aria-labelledby="triggerId">
                    <a class="dropdown-item"
                        href="{{ route('car.category', ['type_id' => Request::route('type_id')]) }}">All</a>
                    <a class="dropdown-item"
                        href="{{ route('car.list.category.pricedesc', ['type_id' => Request::route('type_id')]) }}">Price
                        High to Low</a>
                    <a class="dropdown-item"
                        href="{{ route('car.list.category.priceasc', ['type_id' => Request::route('type_id')]) }}">Price
                        Low
                        to High</a>
                </div>
            </div>
        </li>
        <li class="list-inline-item">
            <form action="{{ route('car.list.category.location', ['type_id' => Request::route('type_id')]) }}"
                method="post" class="form-inline needs-validation" novalidate>
                @csrf
                <div class="input-group">
                    <input class="form-control" type="search" name="search-location" placeholder="Search by location"
                        aria-label="Search" required>
                    <div class="invalid-tooltip">
                        Please enter a search string.
                    </div>
                    <div class="input-group-prepend">
                        <button class="btn btn-success" type="submit">Search <i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
        </li>
    </ul>
    @if (\Route::current()->getName() == 'car.list.category.pricedesc')
        <div class="row p-0 m-0">
            <div class="col col-12">
                <p class="text-center h1 mt-5 align-middle">List of the available rental cars</p>
                <div class="row cont-row">
                    @foreach ($pricedesc as $list)
                        <div class="col-sm-3 my-5">
                            <div class="card" style="width: 100%; min-height: 100%">
                                <img src="{{ asset('images/car/images/' . $list->primary_image) }}" class="card-img-top"
                                    alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $list->model }}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">{{ $list->model_year }}</h6>
                                    <p class="card-text" title="{{ $list->description }}">
                                        {{ substr($list->description, 0, 50) }}</p>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Brand: {{ $list->brand }}</li>
                                        <li class="list-group-item">Color: {{ $list->color }}</li>
                                        <li class="list-group-item">Capacity: {{ $list->people_no }}</li>
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
    @elseif (\Route::current()->getName() == 'car.list.category.priceasc')
        <div class="row p-0 m-0">
            <div class="col col-12">
                <p class="text-center h1 mt-5 align-middle">List of the available rental cars</p>
                <div class="row cont-row">
                    @foreach ($priceasc as $list)
                        <div class="col-sm-3 my-5">
                            <div class="card" style="width: 100%; min-height: 100%">
                                <img src="{{ asset('images/car/images/' . $list->primary_image) }}" class="card-img-top"
                                    alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $list->model }}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">{{ $list->model_year }}</h6>
                                    <p class="card-text" title="{{ $list->description }}">
                                        {{ substr($list->description, 0, 50) }}</p>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Brand: {{ $list->brand }}</li>
                                        <li class="list-group-item">Color: {{ $list->color }}</li>
                                        <li class="list-group-item">Capacity: {{ $list->people_no }}</li>
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
    @elseif (\Route::current()->getName() == 'car.list.category.location')
        <div class="row p-0 m-0">
            <div class="col col-12">
                <p class="text-center h1 mt-5 align-middle">List of the available rental cars</p>
                <div class="row cont-row">
                    @forelse ($location as $list)
                        <div class="col-sm-3 my-5">
                            <div class="card" style="width: 100%; min-height: 100%">
                                <img src="{{ asset('images/car/images/' . $list->primary_image) }}" class="card-img-top"
                                    alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $list->model }}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">{{ $list->model_year }}</h6>
                                    <p class="card-text" title="{{ $list->description }}">
                                        {{ substr($list->description, 0, 50) }}</p>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Brand: {{ $list->brand }}</li>
                                        <li class="list-group-item">Color: {{ $list->color }}</li>
                                        <li class="list-group-item">Capacity: {{ $list->people_no }}</li>
                                    </ul>
                                    <a href="{{ route('car.detail', ['car-id' => $list->id]) }}"
                                        class="btn btn-primary mt-3">View
                                        Deal <span class="material-icons align-middle">
                                            local_offer
                                        </span></a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-warning" role="alert">
                            <strong>None of the company rent cars to "{{ Request::get('search-location') }}". Please try
                                other locations.</strong>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    @else
        <div class="row p-0 m-0">
            <div class="col col-12">
                <p class="text-center h1 mt-5 align-middle">List of the available rental cars</p>
                <div class="row cont-row">
                    @foreach ($lists as $list)
                        <div class="col-sm-3 my-5">
                            <div class="card" style="width: 100%; min-height: 100%">
                                <img src="{{ asset('images/car/images/' . $list->primary_image) }}" class="card-img-top"
                                    alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $list->model }}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">{{ $list->model_year }}</h6>
                                    <p class="card-text" title="{{ $list->description }}">
                                        {{ substr($list->description, 0, 50) }}</p>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Brand: {{ $list->brand }}</li>
                                        <li class="list-group-item">Color: {{ $list->color }}</li>
                                        <li class="list-group-item">Capacity: {{ $list->type->people_no }}</li>
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
    @endif
@endsection
