@extends('layouts.dashboard')

@section('title', 'Users')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <p class="text-center h1 title">USERS</p>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Admin Lists</h5>
                    <p class="card-text">Here are the lists of all the admins in the system.</p>
                    <div>
                        <button id="exportCSV" onclick="exportTableToCSV('AdminList.csv', 'exportAdminTable')"
                            class="btn border"><i class="fas fa-file-csv fa-2x align-middle"></i>CSV</button>
                        <button id="exportPDF" onclick="generate('AdminList', 'exportAdminTable')" class="btn border"><i
                                class="fas fa-file-pdf fa-2x align-middle"></i>PDF</button>
                        <button type="button" class="btn btn-primary mb-2 float-right" data-toggle="modal"
                            data-target="#addadmin">
                            <span class="material-icons">
                                add_circle
                            </span>
                        </button>

                        <div class="modal fade" id="addadmin" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <form action="{{ route('admin.user.admin.add') }}" method="post" class="needs-validation"
                                novalidate>
                                @csrf
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Add Admin User</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col form-group">
                                                    <label>First name</label>
                                                    <input type="text" class="form-control" name="firstname"
                                                        placeholder="Enter firstname...." required>
                                                </div>
                                                <div class="col form-group">
                                                    <label>Last name</label>
                                                    <input type="text" class="form-control" name="lastname"
                                                        placeholder="Enter lastname...." required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col form-group">
                                                    <label>Contact</label>
                                                    <input type="text" class="form-control" name="contact"
                                                        placeholder="Enter contact...." required>
                                                </div>
                                                <div class="col form-group">
                                                    <label>Address</label>
                                                    <input type="text" class="form-control" name="address"
                                                        placeholder="Enter address...." required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Date of birth</label>
                                                <input type="date" class="form-control" name="date_of_birth"
                                                    placeholder="Enter DOB...." required>
                                            </div>
                                            <div class="form-group">
                                                <label>E-mail</label>
                                                <input type="email" class="form-control" name="email"
                                                    placeholder="Enter email...." required>
                                            </div>
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input type="text" class="form-control" name="username"
                                                    placeholder="Enter username...." required>
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" class="form-control" name="password"
                                                    placeholder="Enter password...." minlength="8" required>
                                                <div class="invalid-feedback">
                                                    Must be 8 characters
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Add admin</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table id="exportAdminTable" class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Address</th>
                                        <th>Contact</th>
                                        <th>D.O.B</th>
                                        <th>Email</th>
                                        <th>Username</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($admin_results as $list)
                                        <tr>
                                            <td>{{ $list->id }}</td>
                                            <td>{{ $list->firstname }}</td>
                                            <td>{{ $list->lastname }}</td>
                                            <td>{{ $list->address }}</td>
                                            <td>{{ $list->contact }}</td>
                                            <td>{{ $list->date_of_birth }}</td>
                                            <td>{{ $list->email }}</td>
                                            <td>{{ $list->username }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                                        data-target="#{{ $list->id }}">
                                                        <span class="material-icons">
                                                            edit
                                                        </span>
                                                    </button>
                                                    <div class="modal fade" id="{{ $list->id }}" tabindex="-1"
                                                        role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <form
                                                            action="{{ route('admin.user.admin.edit', ['id' => $list->id]) }}"
                                                            method="post" class="needs-validation" novalidate>
                                                            @csrf
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Edit
                                                                            Admin
                                                                            User</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col form-group">
                                                                                <label>First name</label>
                                                                                <input type="text" class="form-control"
                                                                                    name="firstname"
                                                                                    value="{{ $list->firstname }}"
                                                                                    placeholder="Enter firstname...."
                                                                                    required>
                                                                            </div>
                                                                            <div class="col form-group">
                                                                                <label>Last name</label>
                                                                                <input type="text" class="form-control"
                                                                                    name="lastname"
                                                                                    value="{{ $list->lastname }}"
                                                                                    placeholder="Enter lastname...."
                                                                                    required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col form-group">
                                                                                <label>Contact</label>
                                                                                <input type="text" class="form-control"
                                                                                    name="contact"
                                                                                    value="{{ $list->contact }}"
                                                                                    placeholder="Enter contact...."
                                                                                    required>
                                                                            </div>
                                                                            <div class="col form-group">
                                                                                <label>Address</label>
                                                                                <input type="text" class="form-control"
                                                                                    name="address"
                                                                                    value="{{ $list->address }}"
                                                                                    placeholder="Enter address...."
                                                                                    required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Date of birth</label>
                                                                            <input type="date" class="form-control"
                                                                                name="date_of_birth"
                                                                                value="{{ $list->date_of_birth }}"
                                                                                placeholder="Enter DOB...." required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>E-mail</label>
                                                                            <input type="email" class="form-control"
                                                                                name="email" value="{{ $list->email }}"
                                                                                placeholder="Enter email...." required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Username</label>
                                                                            <input type="text" class="form-control"
                                                                                name="username"
                                                                                value="{{ $list->username }}"
                                                                                placeholder="Enter username...." required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Password</label>
                                                                            <input type="password" class="form-control"
                                                                                name="password"
                                                                                placeholder="Enter password...."
                                                                                minlength="8" required>
                                                                            <div class="invalid-feedback">
                                                                                Must be 8 characters
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Edit
                                                                            admin user</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <a href="{{ route('admin.delete.user', ['id' => $list->id]) }}"
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
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="text-danger">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Owner Lists</h5>
                    <p class="card-text">Here are the lists of all the company owners in the system.</p>
                    <div class="mb-1">
                        <button id="exportCSV" onclick="exportTableToCSV('OwnerList.csv', 'exportOwnerTable')"
                            class="btn border"><i class="fas fa-file-csv fa-2x align-middle"></i>CSV</button>
                        <button id="exportPDF" onclick="generate('OwnerList', 'exportOwnerTable')" class="btn border"><i
                                class="fas fa-file-pdf fa-2x align-middle"></i>PDF</button>
                    </div>
                    <div>
                        <div class="table-responsive">
                            <table id="exportOwnerTable" class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Address</th>
                                        <th>Contact</th>
                                        <th>D.O.B</th>
                                        <th>Email</th>
                                        <th>Username</th>
                                        {{-- <th>Company Name</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($company_results as $list)
                                        <tr>
                                            <th>{{ $list->id }}</th>
                                            <td>{{ $list->firstname }}</td>
                                            <td>{{ $list->lastname }}</td>
                                            <td>{{ $list->address }}</td>
                                            <td>{{ $list->contact }}</td>
                                            <td>{{ $list->date_of_birth }}</td>
                                            <td>{{ $list->email }}</td>
                                            <td>{{ $list->username }}</td>
                                            {{-- <td>{{ $list->company->name }}</td> --}}
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.delete.user', ['id' => $list->id]) }}"
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

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Users List</h5>
                    <p class="card-text">Here are the lists of all the users in the system.</p>
                    <div class="mb-1">
                        <button id="exportCSV" onclick="exportTableToCSV('UsersList.csv', 'exportUserTable')"
                            class="btn border"><i class="fas fa-file-csv fa-2x align-middle"></i>CSV</button>
                        <button id="exportPDF" onclick="generate('UsersList', 'exportUserTable')" class="btn border"><i
                                class="fas fa-file-pdf fa-2x align-middle"></i>PDF</button>
                    </div>
                    <div>
                        <div class="table-responsive">
                            <table id="exportUserTable" class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Address</th>
                                        <th>Contact</th>
                                        <th>D.O.B</th>
                                        <th>Email</th>
                                        <th>Username</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user_results as $list)
                                        <tr>
                                            <th>{{ $list->id }}</th>
                                            <td>{{ $list->firstname }}</td>
                                            <td>{{ $list->lastname }}</td>
                                            <td>{{ $list->address }}</td>
                                            <td>{{ $list->contact }}</td>
                                            <td>{{ $list->date_of_birth }}</td>
                                            <td>{{ $list->email }}</td>
                                            <td>{{ $list->username }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    {{-- <a href="{{ route('edit-car', ['edit-id' => $list->id]) }}"
                                                        class="btn btn-info">Edit</a> --}}
                                                    <a href="{{ route('admin.delete.user', ['id' => $list->id]) }}"
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
