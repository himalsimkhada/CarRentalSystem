@extends('layouts.dashboard')

@section('title', 'Messages')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Messages</h4>
                    <table class="table table-striped table-inverse table-responsive">
                        <thead class="thead-inverse">
                            <tr>
                                <th>Fullname</th>
                                <th>Email</th>
                                <th>Contact Number</th>
                                <th>Message</th>
                                <th>Type</th>
                                <th>Priority</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($messages as $message)
                                <tr>
                                    <td>{{ $message->fullname }}</td>
                                    <td>{{ $message->email }}</td>
                                    <td>{{ $message->contact_num }}</td>
                                    <td>{{ $message->message }}</td>
                                    <td>{{ $message->type }}</td>
                                    <td>{{ $message->priority }}</td>
                                    <td>{{ $message->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
