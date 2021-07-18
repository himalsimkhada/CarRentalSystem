@extends('layouts.dashboard')

@section('title', 'Cars')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <p class="text-center title">CARS</p>
            <div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Cars List</h5>
                        <p class="card-text">Here are all the cars that are on the system.</p>
                        <div class="mb-1">
                            <button id="exportCSV" onclick="exportTableToCSV('CarsList.csv', 'exportTable')"
                                class="btn border"><i class="fas fa-file-csv fa-2x align-middle"></i>CSV</button>
                            <button id="exportPDF" onclick="generate('CarsList', 'exportTable')" class="btn border"><i
                                    class="fas fa-file-pdf fa-2x align-middle"></i>PDF</button>
                        </div>
                        <div class="table-responsive">
                            <table id="exportTable" class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Model Name</th>
                                        <th>Model Year</th>
                                        <th>Brand</th>
                                        <th>Color</th>
                                        <th>Plate Number</th>
                                        <th>Availability</th>
                                        <th id="action">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($results as $list)
                                        <tr>
                                            <td>{{ $list->id }}</td>
                                            <td>{{ $list->model }}</td>
                                            <td>{{ $list->model_year }}</td>
                                            <td>{{ $list->brand }}</td>
                                            <td>{{ $list->color }}</td>
                                            <td>{{ $list->plate_number }}</td>
                                            <td>
                                                @if ($list->availability == 0)
                                                    Not Available
                                                @elseif ($list->availability == 1)
                                                    Available
                                                @endif
                                            </td>
                                            <td id="action">
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.delete.car', ['id' => $list->id]) }}"
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
