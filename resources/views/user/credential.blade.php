@extends('layouts.dashboard')

@section('title', 'Credentials')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <p class="text-center h1 title">User Credentials</p>
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#addCredential">
                <span class="material-icons">
                    add_circle
                </span>
            </button>
            {{-- modal --}}
            <div class="modal fade" id="addCredential" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Credentials</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('user.store.credential') }}" method="post" enctype="multipart/form-data"
                            class="needs-validation" novalidate>
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Credential Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Credential ID</label>
                                    <input type="text" name="type_number" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>File</label>
                                    <input type="file" name="credential_file" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Credential Image</label>
                                    <input type="file" name="image" class="form-control" required>
                                </div>
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
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">User Credentials</h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Credential Type No.</th>
                                            <th>File</th>
                                            <th>Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($credentials as $credential)
                                            <tr>
                                                <th>{{ $credential->id }}</th>
                                                <th>{{ $credential->credential_name }}</th>
                                                <th>{{ $credential->credential_id }}</th>
                                                <th><a href="{{ asset('user/credentials/files/' . $credential->credential_file) }}"
                                                        class="text-info">Download</a></th>
                                                <th>{{ $credential->image }}</th>
                                                <th>
                                                    <div class="btn-group float-right">
                                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                                            data-target="#{{ $credential->id }}">
                                                            <span class="material-icons">
                                                                edit
                                                            </span>
                                                        </button>
                                                        <div class="modal fade" id="{{ $credential->id }}" tabindex="-1"
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
                                                                    <form action="{{ route('user.update.credential') }}"
                                                                        method="post" enctype="multipart/form-data"
                                                                        class="needs-validation" novalidate>
                                                                        @csrf
                                                                        <div class="modal-body">
                                                                            <div class="form-group">
                                                                                <input type="text" name="id"
                                                                                    value="{{ $credential->id }}" hidden>

                                                                                <label>Credential Name</label>
                                                                                <input type="text" name="name"
                                                                                    value="{{ $credential->credential_name }}"
                                                                                    class="form-control" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Credential ID</label>
                                                                                <input type="text" name="type_number"
                                                                                    value="{{ $credential->credential_id }}"
                                                                                    class="form-control" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>File</label>
                                                                                <input type="file" name="credential_file"
                                                                                    class="form-control" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Credential Image</label>
                                                                                <input type="file" name="image"
                                                                                    class="form-control" required>
                                                                            </div>
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
                                                        <a href="{{ route('user.delete.credential', ['id' => $credential->id]) }}"
                                                            class="btn btn-danger"><span class="material-icons">
                                                                remove_circle
                                                            </span></a>
                                                    </div>
                                                </th>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
