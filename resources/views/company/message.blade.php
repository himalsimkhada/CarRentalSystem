@extends('layouts.dashboard')

@section('title', 'Messages')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Messages</h4>
                    <h6 class="card-title">Please click on email to contact the customer or contact the customer using
                        number.</h6>
                    <table class="table table-striped table-inverse table-responsive">
                        <thead class="thead-inverse">
                            <tr>
                                <th>Fullname</th>
                                <th>Email</th>
                                <th>Contact Number</th>
                                <th>Message</th>
                                <th>Type</th>
                                <th>Priority</th>
                                <th>Support Status</th>
                                <th>Email Customer</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($messages as $message)
                                <tr>
                                    <td>{{ $message->fullname }}</td>
                                    <td><a href="" class="btn-link">{{ $message->email }}</a></td>
                                    <td><a href="" class="btn-link">{{ $message->contact_num }}</a></td>
                                    <td>{{ $message->message }}</td>
                                    <td>{{ $message->type }}</td>
                                    <td>{{ $message->priority }}</td>
                                    <td>{{ $message->status }}</td>
                                    <td><button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#emailCustomer">
                                            Email
                                        </button></td>
                                    <div class="modal fade" id="emailCustomer" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Email customer</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form
                                                    action="{{ route('company.support.customer', ['user_id' => $message->user_id, 'id' => $message->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <textarea class="form-control" name="email_message" cols="30"
                                                            rows="10"
                                                            placeholder="Please type your email message here."></textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Email</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
