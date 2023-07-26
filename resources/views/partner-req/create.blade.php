@extends('layouts.app')

@section('title', 'Partner Request')

@section('content')
    <style>
        body {
            /* background-color: #25274d; */
        }

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
    <form action="{{ route('partner-req.store') }}" method="post" class="needs-validation" novalidate>
        @csrf
        <div class="container contact">
            <div class="row">
                <div class="col-md-3">
                    <div class="contact-info">
                        {{-- <img src="https://image.ibb.co/kUASdV/contact-image.png" alt="image" /> --}}
                        <h2>Rent with us.</h2>
                        <h4>We would love to work with you !</h4>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="contact-form">
                        <div class="mb-3">
                            <div class="col-sm-10">
                                <div class="mb-3">
                                    <label for="name">Company Name</label>
                                    <input type="text" class="form-control" name="company_name" id="name"
                                        aria-describedby="helpId" placeholder="" required>
                                    <small id="helpId" class="form-text text-muted">Please provide company name.
                                        (required)</small>
                                </div>
                                <div class="mb-3">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" name="company_address" id="address"
                                        aria-describedby="helpId" placeholder="" required>
                                    <small id="helpId" class="form-text text-muted">Please provide company full
                                        address. (required)</small>
                                </div>
                                <div class="mb-3">
                                    <label for="contact">Contact</label>
                                    <input type="text" class="form-control" name="company_contact" id="contact"
                                        aria-describedby="helpId" placeholder="" required>
                                    <small id="helpId" class="form-text text-muted">Please provide company contact.
                                        (required)</small>
                                </div>
                                <div class="mb-3">
                                    <label for="reg_id">Registration ID</label>
                                    <input type="text" class="form-control" name="registration_number" id="reg_id"
                                        aria-describedby="helpId" placeholder="" required>
                                    <small id="helpId" class="form-text text-muted">Please provide company registration
                                        id.
                                        (required)</small>
                                </div>
                                <div class="mb-3">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="company_email" id="email"
                                        aria-describedby="helpId" placeholder="" required>
                                    <small id="helpId" class="form-text text-muted">Please provide company Email.
                                        (required)</small>
                                </div>
                                <div class="mb-3">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" name="company_description" id="description" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default">Submit</button>
                            </div>
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
    </form>
@endsection
