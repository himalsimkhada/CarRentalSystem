@extends('layouts.dashboard')

@section('title', 'Companies')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <p class="text-center h1 title">COMPANY</p>
            <div class="card">
                <div class="card-body">
                    <p class="card-text">Lists of all the companies registered in the system.</p>
                    <div class="mb-1">
                        <button id="exportCSV" onclick="exportTableToCSV('CompaniesList.csv', 'exportCompanyTable')"
                            class="btn border"><i class="fas fa-file-csv fa-2x align-middle"></i>CSV</button>
                        <button id="exportPDF" onclick="generate('CompaniesList', 'exportCompanyTable')"
                            class="btn border"><i class="fas fa-file-pdf fa-2x align-middle"></i>PDF</button>
                    </div>
                    <div>
                        <div class="modal fade" id="addCompany" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Insert company details</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('admin.add.company') }}" method="post" class="needs-validation"
                                        novalidate>
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="control-label">Company Name</label>
                                                <input type="text" class="form-control" name="name">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Description</label>
                                                <textarea class="form-control" name="description"></textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col form-group">
                                                    <label class="control-label">Address</label>
                                                    <input type="text" class="form-control" name="address">
                                                </div>
                                                <div class="col form-group">
                                                    <label class="control-label">Contact</label>
                                                    <input type="text" class="form-control" name="contact">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Registration Number</label>
                                                <input type="text" class="form-control" name="registration_number">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">E-mail</label>
                                                <input type="email" class="form-control" name="email">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Owner</label>
                                                <select name="owner_id" class="form-control" required>
                                                    <option value="#" disabled selected>Select Owner</option>
                                                    @foreach ($owner as $val)
                                                        <option value="{{ $val->id }}">{{ $val->username }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Add</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div>
                            <div class="table-responsive">
                                <table id="exportCompanyTable" class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Company Name</th>
                                            <th>Address</th>
                                            <th>Contact</th>
                                            <th>Registration Number</th>
                                            <th>Email</th>
                                            <th>Username</th>
                                            <th>Areas</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($results as $list)
                                            <tr>
                                                <th>{{ $list->id }}</th>
                                                <td>{{ $list->name }}</td>
                                                <td>{{ $list->address }}</td>
                                                <td>{{ $list->contact }}</td>
                                                <td>{{ $list->registration_number }}</td>
                                                <td>{{ $list->email }}</td>
                                                <td>{{ $list->username }}</td>
                                                <td>{{ $list->rent_areas }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('admin.delete.company', ['id' => $list->id]) }}"
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
                    <div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCompany">
                                Add a company
                                <span class="material-icons align-middle">
                                    business
                                </span>
                            </button>
                            <a href="{{ route('admin.requests') }}" class="btn btn-success">Partner Request <span
                                    class="material-icons align-middle">
                                    person_add
                                </span></a>
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
