@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
    <style>
        .contact {
            padding: 4%;
            height: 400px;
        }

        .col-md-3 {
            background: #ff9b00;
            padding: 4%;
            border-top-left-radius: 0.5rem;
            border-bottom-left-radius: 0.5rem;
        }

        .contact-info {
            margin-top: 10%;
        }

        .contact-info img {
            margin-bottom: 15%;
        }

        .contact-info h2 {
            margin-bottom: 10%;
        }

        .col-md-9 {
            background: #fff;
            padding: 3%;
            border-top-right-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
        }

        .contact-form label {
            font-weight: 600;
        }

        .contact-form button {
            background: #25274d;
            color: #fff;
            font-weight: 600;
            width: 25%;
        }

        .contact-form button:focus {
            box-shadow: none;
        }
    </style>
    <form
        action="@if (\Auth::check()) {{ route('contactus.post', ['id' => auth()->user()->id]) }} @else {{ route('contactus.post') }} @endif"
        method="post" class="needs-validation" novalidate>
        @csrf
        <div class="container contact">
            <div class="row">
                <div class="col-md-3">
                    <div class="contact-info">
                        <h2>Contact Us</h2>
                        <h4>We would love to hear from you !</h4>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="contact-form">
                        @if (\Auth::check())
                            <div class="mb-3">
                                <label class="form-label col-sm-2" for="fname">Full Name:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"
                                        value="{{ $user->firstname . ' ' . $user->lastname }}" id="fname"
                                        placeholder="Enter Full Name" name="fullname" readonly required>
                                </div>
                            </div>
                        @else
                            <div class="mb-3">
                                <label class="form-label col-sm-2" for="fname">Full Name:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="fname" placeholder="Enter Full Name"
                                        name="fullname" required>
                                </div>
                            </div>
                        @endif
                        @if (\Auth::check())
                            <div class="mb-3">
                                <label class="form-label col-sm-2" for="email">Email:</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="email" value="{{ $user->email }}"
                                        placeholder="Enter email" name="email" readonly required>
                                </div>
                            </div>
                        @else
                            <div class="mb-3">
                                <label class="form-label col-sm-2" for="email">Email:</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="email" placeholder="Enter email"
                                        name="email" required>
                                </div>
                            </div>
                        @endif
                        @if (\Auth::check())
                            <div class="mb-3">
                                <label class="form-label col-sm-2" for="contact">Contact Num:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="contact" value="{{ $user->contact }}"
                                        placeholder="Enter contact number" name="contact_num" required>
                                </div>
                            </div>
                        @else
                            <div class="mb-3">
                                <label class="form-label col-sm-2" for="contact">Contact Num:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="contact"
                                        placeholder="Enter contact number" name="contact_num" required>
                                </div>
                            </div>
                        @endif
                        <div class="mb-3">
                            <label class="form-label col-sm-2">Type:</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="type" id="" required>
                                    <option selected disabled>Select a type</option>
                                    @if (\Auth::check())
                                        <option value="emr">Emergency Vehicle Replacement</option>
                                    @endif
                                    <option value="req_car">Request vehicle for other locations</option>
                                    <option value="others">Others (Fill up the message box)</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label col-sm-2" for="message">Message:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="5" id="message" name="message" required></textarea>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default">Submit</button>
                                <a href="{{ route('partner-req.create') }}" class="btn btn-success">Become a partner</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="invalid-feedback">
                    {{ $error }}
                </div>
            @endforeach
        @endif
    </form>
@endsection
