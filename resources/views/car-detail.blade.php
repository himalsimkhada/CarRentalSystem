@extends('layouts.app')

@section('title', 'Car Details')

@section('content')
    <div class="container" id="product-section">
        @foreach ($car_detail as $detail)
            <div class="row my-5">
                <div class="col-md-8">
                    <h4>{{ $detail->model }}</h4>
                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100"
                                    src="{{ asset('images/car/images/' . $detail->primary_image) }}" alt="">
                            </div>
                            @foreach ($images as $image)
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="{{ asset('images/car/images/' . $image->image) }}"
                                        alt="">
                                </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div>
                        <h3 class="text-right">Details</h3>
                        <div class="card my-5" style="width: auto;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $detail->model }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $detail->brand }}</h6>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $detail->model_year }}</h6>
                                <p class="card-text">{{ $detail->description }}</p>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Color: {{ $detail->color }}</li>
                                    <li class="list-group-item">Capacity: {{ $detail->type->people_no }}</li>
                                    <li class="list-group-item">Availability: {{ $detail->availability }}</li>
                                    <li class="list-group-item">Company: {{ $detail->company->name }}</li>
                                </ul>
                                <p class="pricing">Cost (Per Day): ${{ $detail->type->cost }}</p>
                                <div class="booking">
                                    <button type="button" class="btn btn-success form-control text-left" data-toggle="modal"
                                        data-target="#bookingDialouge">Book<i class="fas fa-car float-right align-middle"
                                            style="font-size: 25px"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="bookingDialouge" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Reservation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        @if (Request::has('date') || Request::has('return') || Request::has('type'))
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Pick Date</label>
                                    <input type="date" name="date" value="{{ Request::get('date') }}"
                                        class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Drop Date</label>
                                    <input type="date" name="return-date" class="form-control"
                                        value="{{ Request::get('return') }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Booking Type</label>
                                    <input type="text" name="bookingtype" class="form-control"
                                        value="{{ $detail->type->name }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Location</label>
                                    <input type="text" name="location" class="form-control"
                                        value="{{ Request::get('location') }}" readonly>
                                    <small id="helpId" class="text-muted">Location</small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><span
                                        class="material-icons">
                                        cancel
                                    </span></button>
                                <a href="{{ route('user.car.book.index', ['car-id' => $detail->id, 'pickdate' => $pickdate, 'dropdate' => $dropdate, 'bookingtype' => $bookingtype]) }}"
                                    class="btn btn-primary">Book</a>
                            </div>
                        @else
                            <form action="{{ route('user.car.book.list', ['car-id' => $detail->id]) }}" method="post"
                                class="needs-validation" novalidate>
                                @csrf
                                <div class="modal-body">
                                    <input type="text" name="car_id" value="{{ Request::get('car-id') }}" hidden>
                                    <div class="form-group">
                                        <label>Pick Date</label>
                                        <input type="date" name="date" value="{{ date('Y-m-d') }}"
                                            min="{{ date('Y-m-d') }}" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Drop Date</label>
                                        <input type="date" name="return_date" min="{{ date('Y-m-d') }}"
                                            class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Booking Type</label>
                                        <input type="text" name="bookingtype" value="{{ $type_name }}"
                                            class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Location</label>
                                        <select class="custom-select" name="location">
                                            <option selected disabled>Select one</option>
                                            @foreach ($locations as $location)
                                                <option value="{{ $location->id }}">{{ $location->location }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span
                                            class="material-icons">
                                            cancel
                                        </span></button>
                                    <button type="submit" class="btn btn-primary">Book</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
