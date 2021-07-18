@extends('layouts.dashboard')

@section('title', 'Cars')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <p class="text-center h1 title">CARS</p>
            <div class="card">
                <div class="card-header">
                    Cars List
                    <div class="btn-group float-right">
                        <a href="{{ route('company.add.car.view') }}" class="btn btn-secondary">Add a car</a>
                        <a href="{{ route('company.add.car.view') }}" class="btn btn-success"><span
                                class="material-icons">
                                add
                            </span></a>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <div class="mb-1">
                            <button id="exportCSV" onclick="exportTableToCSV('CarsList.csv', 'exportCarTable')"
                                class="btn border"><i class="fas fa-file-csv fa-2x align-middle"></i>CSV</button>
                            <button id="exportPDF" onclick="generate('CarsList', 'exportCarTable')" class="btn border"><i
                                    class="fas fa-file-pdf fa-2x align-middle"></i>PDF</button>
                        </div>
                    </div>
                    <div>
                        <div class="table-responsive">
                            <table id="exportCarTable" class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Model Name</th>
                                        <th>Description</th>
                                        <th>Model Year</th>
                                        <th>Brand</th>
                                        <th>Color</th>
                                        <th>Plate Number</th>
                                        <th>Availability</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($car_lists as $list)
                                        <tr>
                                            <th>{{ $list->id }}</th>
                                            <td>{{ $list->model }}</td>
                                            <td>{{ $list->description }}</td>
                                            <td>{{ $list->model_year }}</td>
                                            <td>{{ $list->brand }}</td>
                                            <td>{{ $list->color }}</td>
                                            <td>{{ $list->plate_number }}</td>
                                            <td>{{ $list->availability }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('company.edit.view.car', ['edit-id' => $list->id]) }}"
                                                        class="btn btn-info"><span class="material-icons">
                                                            edit
                                                        </span></a>
                                                    <button type="button" class="btn btn-secondary" data-toggle="modal"
                                                        data-target="#{{ $list->id }}">
                                                        <span class="material-icons">
                                                            add_photo_alternate
                                                        </span>
                                                    </button>
                                                    <div class="modal fade" id="{{ $list->id }}" tabindex="-1"
                                                        role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Modal
                                                                        title
                                                                    </h5>
                                                                    <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form action="{{ route('company.car.store.image', ['id' => $list->id]) }}"
                                                                    method="post" class="needs-validation"
                                                                    enctype="multipart/form-data" novalidate>
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        <input type="text" name="model"
                                                                            value="{{ $list->model }}" hidden>
                                                                        <div class="form-group">
                                                                            <label>Car Image</label>
                                                                            <input type="file" name="image"
                                                                                class="form-control" required>
                                                                        </div>
                                                                        @if ($errors->any())
                                                                            @foreach ($errors->all() as $error)
                                                                                <div class="invalid-feedback">
                                                                                    {{ $error }}
                                                                                </div>
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Add</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="{{ route('company.delete.car', ['id' => $list->id]) }}"
                                                        class="btn btn-danger"><span class="material-icons">
                                                            delete
                                                        </span></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
