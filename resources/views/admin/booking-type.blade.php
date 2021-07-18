@extends('layouts.dashboard')

@section('title', 'Booking Type')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <p class="text-center h1 title">Booking Types</p>
            <div class="card">
                <div class="card-body">
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                        data-target="#addCredential">
                        <span class="material-icons">
                            add_circle
                        </span>
                    </button>

                    <div class="modal fade" id="addCredential" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Type</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('admin.booking.type.add') }}" method="post"
                                    enctype="multipart/form-data" class="needs-validation" novalidate>
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Type Name</label>
                                            <input type="text" name="name" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Luggage Number</label>
                                            <input type="text" name="luggage_no" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>People Number</label>
                                            <input type="text" name="people_no" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Cost</label>
                                            <input type="text" name="cost" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Late Fee</label>
                                            <input type="text" name="late_fee" class="form-control" required>
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
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row m-0">
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Luggage Number</th>
                                            <th>People Number</th>
                                            <th>Cost</th>
                                            <th>Late Fee</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($types as $type)
                                            <tr>
                                                <td>{{ $type->id }}</td>
                                                <td>{{ $type->name }}</td>
                                                <td>{{ $type->luggage_no }}</td>
                                                <td>{{ $type->people_no }}</td>
                                                <td>{{ $type->cost }}</td>
                                                <td>{{ $type->late_fee }}</td>
                                                <td>
                                                    <div class="btn-group float-right">
                                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                                            data-target="#{{ $type->id }}">
                                                            <span class="material-icons">
                                                                edit
                                                            </span>
                                                        </button>
                                                        <div class="modal fade" id="{{ $type->id }}" tabindex="-1"
                                                            role="dialog" aria-labelledby="exampleModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Edit
                                                                            Credentials
                                                                        </h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <form action="{{ route('admin.booking.type.edit', ['id' => $type->id]) }}"
                                                                        method="post" enctype="multipart/form-data"
                                                                        class="needs-validation" novalidate>
                                                                        @csrf
                                                                        <div class="modal-body">
                                                                            <div class="form-group">
                                                                                <label>Type Name</label>
                                                                                <input type="text" name="name"
                                                                                    value="{{ $type->name }}"
                                                                                    class="form-control" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Luggage Number</label>
                                                                                <input type="text" name="luggage_no"
                                                                                    value="{{ $type->luggage_no }}"
                                                                                    class="form-control" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>People Number</label>
                                                                                <input type="text" name="people_no"
                                                                                    value="{{ $type->people_no }}"
                                                                                    class="form-control" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Cost</label>
                                                                                <input type="text" name="cost"
                                                                                    class="form-control"
                                                                                    value="{{ $type->cost }}" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Cost</label>
                                                                                <input type="text" name="late_fee"
                                                                                    class="form-control"
                                                                                    value="{{ $type->late_fee }}"
                                                                                    required>
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
                                                                                class="btn btn-primary">Edit</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <a href="{{ route('admin.booking.type.delete', ['id' => $type->id]) }}"
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
    </div>
@endsection
