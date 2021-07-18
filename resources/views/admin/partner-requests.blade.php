@extends('layouts.dashboard')

@section('title', 'Partner Requests')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <p class="text-center h1 title">REQUESTS</p>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Company Name</th>
                                    <th>Company Description</th>
                                    <th>Company Address</th>
                                    <th>Company Contact</th>
                                    <th>Registration Number</th>
                                    <th>Company Email</th>
                                    <th>Applied User</th>
                                    <th>User ID</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($details as $detail)
                                    <tr>
                                        <td>{{ $detail->req_id }}</td>
                                        <td>{{ $detail->company_name }}</td>
                                        <td>{{ $detail->company_description }}</td>
                                        <td>{{ $detail->company_address }}</td>
                                        <td>{{ $detail->company_contact }}</td>
                                        <td>{{ $detail->company_reg }}</td>
                                        <td>{{ $detail->company_email }}</td>
                                        <td>{{ $detail->username }}</td>
                                        <td>{{ $detail->user_id }}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="">
                                                <a href="{{ route('admin.req.approve', ['r_id' => $detail->req_id]) }}"
                                                    class="btn btn-success"><i class="fas fa-check-circle fa-lg"></i></a>
                                                <a href="{{ route('admin.req.deny', ['deny_id' => $detail->req_id]) }}"
                                                    class="btn btn-danger"><i class="fas fa-ban fa-lg"></i></a>
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
@endsection
