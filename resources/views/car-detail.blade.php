@extends('layouts.app')

@section('title', 'Car Details')

@section('content')
    <div class="container" id="product-section">
        <div class="row my-5">
            <div class="col-md-8">
                <h4>{{ $car->model }}</h4>
                <div id="carouselCarImage" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ file_exists(asset($car->primary_image)) ? asset($car->primary_image) : asset('images/car/images/default.png') }}"
                                class="card-img-top" alt="...">
                        </div>
                        @foreach ($images as $image)
                            <div class="carousel-item">
                                <img class="d-block w-100" src="{{ asset($image->image) }}" alt="">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselCarImage"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselCarImage"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>

                </div>
            </div>
            <div class="col-md-4">
                <div>
                    <h3 class="text-end">Details</h3>
                    <div class="card my-5" style="width: auto;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $car->model }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $car->brand }}</h6>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $car->model_year }}</h6>
                            <p class="card-text">{{ $car->description }}</p>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Color: {{ $car->color }}</li>
                                <li class="list-group-item">Capacity: {{ $car->bookingType->people_no }}</li>
                                <li class="list-group-item">Availability: {{ $car->availability }}</li>
                                <li class="list-group-item">Company: {{ $car->company->name }}</li>
                            </ul>
                            <p class="pricing">Cost (Per Day): ${{ $car->bookingType->cost }}</p>
                            <div class="booking">
                                <button type="button" class="btn btn-success form-control text-start"
                                    data-bs-toggle="modal" data-bs-target="#bookingDialouge">Book<span
                                        class="material-icons float-end align-middle">
                                        payments
                                    </span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="bookingDialouge" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Reservation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    @if (Request::has('date') || Request::has('return') || Request::has('type'))
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Pick Date</label>
                                <input type="date" name="date" value="{{ Request::get('date') }}"
                                    class="form-control" min="{{ date('Y-m-d') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Drop Date</label>
                                <input type="date" name="return-date" class="form-control"
                                    value="{{ Request::get('return') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Booking Type</label>
                                <input type="text" name="bookingtype" class="form-control"
                                    value="{{ $car->bookingType->name }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Location</label>
                                <input type="text" name="location" class="form-control"
                                    value="{{ Request::get('location') }}" readonly>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                            <a href="{{ route('user.car.book.index', ['car-id' => $car->id, 'pickdate' => $pickdate, 'dropdate' => $dropdate, 'bookingtype' => $bookingtype]) }}"
                                class="btn btn-primary">Book</a>
                        </div>
                    @else
                        <form action="{{ route('user.car.book.list', ['car-id' => $car->id]) }}" method="post"
                            class="needs-validation" novalidate>
                            @csrf
                            <div class="modal-body">
                                <input type="text" name="car_id" value="{{ Request::get('car-id') }}" hidden>
                                <div class="mb-3">
                                    <label class="form-label">Pick Date</label>
                                    <input type="date" name="date" value="{{ date('Y-m-d') }}"
                                        min="{{ date('Y-m-d') }}" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Drop Date</label>
                                    <input type="date" name="return_date" min="{{ date('Y-m-d') }}"
                                        class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Booking Type</label>
                                    <input type="text" name="bookingtype" value="{{ $type_name }}"
                                        class="form-control" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="">Location</label>
                                    <select class="form-select" name="location">
                                        <option selected disabled>Select one</option>
                                        @foreach ($locations as $location)
                                            <option value="{{ $location->id }}">{{ $location->location }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Book</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
