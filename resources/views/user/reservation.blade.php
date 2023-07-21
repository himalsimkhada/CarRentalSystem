@extends('layouts.dashboard')

@section('title', 'Reservations')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <p class="text-center h1 title">RESERVATION</p>
            <div class="card">
                <div class="dropdown text-right">
                    <button class="btn btn-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Sort By
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{ route('user.reservation') }}">All</a>
                        <a class="dropdown-item" href="{{ route('user.reservation.paid.srt') }}">Paid</a>
                        <a class="dropdown-item" href="{{ route('user.reservation.unpaid.srt') }}">Unpaid</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row m-0">
                        <script
                            src="https://www.paypal.com/sdk/js?client-id=ARIFgwem49nzCY-yr3Sg1zgtWXLX0FjwcaiCVeY6q4rsBNGiInQX5UA8VY2yalAvP239a72phmvYh05B">
                        </script>
                        @if (\Route::current()->getName() == 'user.reservation.paid.srt')
                            @forelse ($srtPaid as $reservation)
                                <div class="col-12 card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="d-inline-block">Reservation</h5>
                                                @if ($reservation->payment == 0)
                                                    <a href="{{ route('user.reservation.delete', ['id' => $reservation->booking_id]) }}"
                                                        class="btn btn-danger d-inline-block float-right">Cancel <span
                                                            class="material-icons align-middle">
                                                            cancel
                                                        </span></a>
                                                @else
                                                    <div class="float-right">
                                                        <span>To get payment details head, <a
                                                                href="https://www.sandbox.paypal.com/myaccount/transactions/"
                                                                class="btn-link">here</a></span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">
                                        <ul class="list-unstyled">
                                            <div class="row">
                                                <div class="col-12">
                                                    <li>Booking Type: <b>{{ $reservation->type_name }}</b></li>
                                                    <li>Car Model: <b>{{ $reservation->model }}</b></li>
                                                    <li>Cost: $<b>{{ $reservation->final_cost }}</b></li>
                                                    <li>Pick-up Date: <b>{{ $reservation->date }}</b></li>
                                                    <li>Drop Date: <b>{{ $reservation->return_date }}</b></li>
                                                </div>
                                            </div>
                                        </ul>
                                        </p>
                                        <small class="text-danger">Once you have paid, it cannot be reversed or refund. So
                                            carefully
                                            edit the details before paying.</small>
                                    </div>
                                    <div class="card-footer text-muted">
                                        <span class="d-inline-block">Reservation date: {{ $reservation->date }}</span>
                                        <div class="float-right d-inline-block">
                                            <span class="d-inline-block">Already paid</span>
                                            <i class="fas fa-check-double d-inline-block text-success"></i>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                There are no reservations
                            @endforelse
                        @elseif (\Route::current()->getName() == 'user.reservation.unpaid.srt')
                            @forelse ($srtUnpaid as $reservation)
                                <div class="col-12 card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="d-inline-block">Reservation</h5>
                                                @if ($reservation->payment == 0)
                                                    <a href="{{ route('user.reservation.delete', ['id' => $reservation->booking_id]) }}"
                                                        class="btn btn-danger d-inline-block float-right">Cancel <span
                                                            class="material-icons align-middle">
                                                            cancel
                                                        </span></a>
                                                @else
                                                    <div class="float-right">
                                                        <span>To get payment details head, <a
                                                                href="https://www.sandbox.paypal.com/myaccount/transactions/"
                                                                class="btn-link">here</a></span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">
                                        <ul class="list-unstyled">
                                            <div class="row">
                                                <div class="col-12">
                                                    <li>Booking Type: <b>{{ $reservation->type_name }}</b></li>
                                                    <li>Car Model: <b>{{ $reservation->model }}</b></li>
                                                    <li>Cost: $<b>{{ $reservation->final_cost }}</b></li>
                                                    <li>Pick-up Date: <b>{{ $reservation->date }}</b></li>
                                                    <li>Drop Date: <b>{{ $reservation->return_date }}</b></li>
                                                </div>
                                            </div>
                                        </ul>
                                        </p>
                                        <small class="text-danger">Once you have paid, it cannot be reversed or refund. So
                                            carefully
                                            edit the details before paying.</small>
                                    </div>
                                    <div class="card-footer text-muted">
                                        <span class="d-inline-block">Reservation date: {{ $reservation->date }}</span>
                                        @if ($reservation->payment == 0)
                                            <div class="d-inline-block float-right"
                                                id="paypal{{ $reservation->booking_id }}">
                                            </div>
                                            <script>
                                                paypal.Buttons({
                                                    style: {
                                                        size: 'responsive',
                                                        shape: 'pill',
                                                        color: 'gold',
                                                        layout: 'vertical',
                                                        label: 'paypal',
                                                    },
                                                    createOrder: function(data, actions) {
                                                        // This function sets up the details of the transaction, including the amount and line item details.
                                                        var cost = "{{ $reservation->final_cost }}";
                                                        // console.log(cost);
                                                        return actions.order.create({
                                                            purchase_units: [{
                                                                amount: {
                                                                    value: cost
                                                                }
                                                            }]
                                                        });
                                                    },
                                                    onApprove: function(data, actions) {
                                                        // This function captures the funds from the transaction.
                                                        return actions.order.capture().then(function(details) {
                                                            // This function shows a transaction success message to your buyer.
                                                            alert('Transaction completed by ' + details
                                                                .payer.name
                                                                .given_name);

                                                            //getting transaction details and posting it on db
                                                            var id =
                                                                "{{ $reservation->booking_id }}";
                                                            var car_id =
                                                                "{{ $reservation->car_id }}";
                                                            var route =
                                                                "{{ route('payment.paid') }}";

                                                            var myForm = document.createElement("form");
                                                            myForm.action = route;
                                                            myForm.method = 'get';
                                                            myForm.setAttribute('id', 'paypal_details');
                                                            myForm.hidden = true;
                                                            document.body.appendChild(myForm);

                                                            var booking_id = document.createElement(
                                                                "input");
                                                            booking_id.setAttribute('type', 'text');
                                                            booking_id.setAttribute('name',
                                                                'booking_id');
                                                            booking_id.setAttribute('value', id);
                                                            booking_id.hidden = true;

                                                            var vehicle_id = document.createElement(
                                                                "input");
                                                            vehicle_id.setAttribute('type', 'text');
                                                            vehicle_id.setAttribute('name', 'car_id');
                                                            vehicle_id.setAttribute('value', car_id);
                                                            vehicle_id.hidden = true;

                                                            var paypal_payer_id = document
                                                                .createElement(
                                                                    "input");
                                                            paypal_payer_id.setAttribute('type',
                                                                'text');
                                                            paypal_payer_id.setAttribute('name',
                                                                'paypal_payer_id');
                                                            paypal_payer_id.setAttribute('value',
                                                                details
                                                                .payer
                                                                .payer_id);

                                                            var paypal_id = document.createElement(
                                                                "input");
                                                            paypal_id.setAttribute('type', 'text');
                                                            paypal_id.setAttribute('name', 'paypal_id');
                                                            paypal_id.setAttribute('value', details.id);

                                                            var paypal_email = document.createElement(
                                                                "input");
                                                            paypal_email.setAttribute('type', 'text');
                                                            paypal_email.setAttribute('name',
                                                                'paypal_email_address');
                                                            paypal_email.setAttribute('value', details
                                                                .payer
                                                                .email_address);

                                                            var c_time = document.createElement(
                                                                "input");
                                                            c_time.setAttribute('type', 'text');
                                                            c_time.setAttribute('name', 'create_time');
                                                            c_time.setAttribute('value', details
                                                                .create_time);

                                                            var u_time = document.createElement(
                                                                "input");
                                                            u_time.setAttribute('type', 'text');
                                                            u_time.setAttribute('name', 'update_time');
                                                            u_time.setAttribute('value', details
                                                                .update_time);

                                                            var paypal_payer_name = document
                                                                .createElement(
                                                                    "input");
                                                            paypal_payer_name.setAttribute('type',
                                                                'text');
                                                            paypal_payer_name.setAttribute('name',
                                                                'paypal_payer_name');
                                                            paypal_payer_name.setAttribute('value',
                                                                details
                                                                .payer
                                                                .name
                                                                .given_name + " " +
                                                                details.payer.name.surname);

                                                            var amount = document.createElement(
                                                                "input");
                                                            amount.setAttribute('type', 'text');
                                                            amount.setAttribute('name', 'amount');
                                                            amount.setAttribute('value', details
                                                                .purchase_units[0]
                                                                .amount.value);

                                                            var address = document.createElement(
                                                                "input");
                                                            address.setAttribute('type', 'text');
                                                            address.setAttribute('name', 'address');
                                                            address.setAttribute('value', details
                                                                .purchase_units[0]
                                                                .shipping.address
                                                                .address_line_1 + "," + details
                                                                .purchase_units[
                                                                    0]
                                                                .shipping.address
                                                                .admin_area_1 + "," + details
                                                                .purchase_units[0]
                                                                .shipping.address
                                                                .admin_area_2);

                                                            myForm.appendChild(booking_id);
                                                            myForm.appendChild(vehicle_id);
                                                            myForm.appendChild(paypal_payer_id);
                                                            myForm
                                                                .appendChild(paypal_id);
                                                            myForm.appendChild(paypal_email);
                                                            myForm
                                                                .appendChild(c_time);
                                                            myForm.appendChild(u_time);
                                                            myForm.appendChild(
                                                                paypal_payer_name);
                                                            myForm.appendChild(amount);
                                                            myForm.appendChild(
                                                                address);

                                                            // console.log(myForm);

                                                            myForm.submit();
                                                        });
                                                    }
                                                }).render('#paypal{{ $reservation->booking_id }}');
                                                /* //This function displays Smart Payment Buttons on your web page. */
                                            </script>
                                        @else
                                            <div class="float-right d-inline-block">
                                                <span class="d-inline-block">Already paid</span>
                                                <i class="fas fa-check-double d-inline-block text-success"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                There are no reservations
                            @endforelse
                        @else
                            @forelse ($reservations as $reservation)
                                <div class="col-12 card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="d-inline-block">Reservation</h5>
                                                @if ($reservation->payment == 0)
                                                    <a href="{{ route('user.reservation.delete', ['id' => $reservation->booking_id]) }}"
                                                        class="btn btn-danger d-inline-block float-right">Cancel <span
                                                            class="material-icons align-middle">
                                                            cancel
                                                        </span></a>
                                                @else
                                                    <div class="float-right">
                                                        <span>To get payment details head, <a
                                                                href="https://www.sandbox.paypal.com/myaccount/transactions/"
                                                                class="btn-link">here</a></span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">
                                        <ul class="list-unstyled">
                                            <div class="row">
                                                <div class="col-12">
                                                    <li>Booking Type: <b>{{ $reservation->type_name }}</b></li>
                                                    <li>Car Model: <b>{{ $reservation->model }}</b></li>
                                                    <li>Cost: $<b>{{ $reservation->final_cost }}</b></li>
                                                    <li>Pick-up Date: <b>{{ $reservation->date }}</b></li>
                                                    <li>Drop Date: <b>{{ $reservation->return_date }}</b></li>
                                                </div>
                                            </div>
                                        </ul>
                                        </p>
                                        <small class="text-danger">Once you have paid, it cannot be reversed or refund. So
                                            carefully
                                            edit the details before paying.</small>
                                    </div>
                                    <div class="card-footer text-muted">
                                        <span class="d-inline-block">Reservation date: {{ $reservation->date }}</span>
                                        @if ($reservation->payment == 0)
                                            <div class="d-inline-block float-right"
                                                id="paypal{{ $reservation->booking_id }}">
                                            </div>
                                            <script>
                                                paypal.Buttons({
                                                    style: {
                                                        size: 'responsive',
                                                        shape: 'pill',
                                                        color: 'gold',
                                                        layout: 'vertical',
                                                        label: 'paypal',
                                                    },
                                                    createOrder: function(data, actions) {
                                                        // This function sets up the details of the transaction, including the amount and line item details.
                                                        var cost = "{{ $reservation->final_cost }}";
                                                        // console.log(cost);
                                                        return actions.order.create({
                                                            purchase_units: [{
                                                                amount: {
                                                                    value: cost
                                                                }
                                                            }]
                                                        });
                                                    },
                                                    onApprove: function(data, actions) {
                                                        // This function captures the funds from the transaction.
                                                        return actions.order.capture().then(function(details) {
                                                            // This function shows a transaction success message to your buyer.
                                                            alert('Transaction completed by ' + details
                                                                .payer.name
                                                                .given_name);

                                                            // console.log(details);

                                                            //getting transaction details and posting it on db
                                                            var id =
                                                                "{{ $reservation->booking_id }}";
                                                            var car_id =
                                                                "{{ $reservation->car_id }}";
                                                            var route =
                                                                "{{ route('payment.paid') }}";

                                                            var myForm = document.createElement("form");
                                                            myForm.action = route;
                                                            myForm.method = 'get';
                                                            myForm.setAttribute('id', 'paypal_details');
                                                            myForm.hidden = true;
                                                            document.body.appendChild(myForm);

                                                            var booking_id = document.createElement(
                                                                "input");
                                                            booking_id.setAttribute('type', 'text');
                                                            booking_id.setAttribute('name',
                                                                'booking_id');
                                                            booking_id.setAttribute('value', id);
                                                            booking_id.hidden = true;

                                                            var vehicle_id = document.createElement(
                                                                "input");
                                                            vehicle_id.setAttribute('type', 'text');
                                                            vehicle_id.setAttribute('name', 'car_id');
                                                            vehicle_id.setAttribute('value', car_id);
                                                            vehicle_id.hidden = true;

                                                            var paypal_payer_id = document
                                                                .createElement(
                                                                    "input");
                                                            paypal_payer_id.setAttribute('type',
                                                                'text');
                                                            paypal_payer_id.setAttribute('name',
                                                                'paypal_payer_id');
                                                            paypal_payer_id.setAttribute('value',
                                                                details
                                                                .payer
                                                                .payer_id);

                                                            var paypal_id = document.createElement(
                                                                "input");
                                                            paypal_id.setAttribute('type', 'text');
                                                            paypal_id.setAttribute('name', 'paypal_id');
                                                            paypal_id.setAttribute('value', details.id);

                                                            var paypal_email = document.createElement(
                                                                "input");
                                                            paypal_email.setAttribute('type', 'text');
                                                            paypal_email.setAttribute('name',
                                                                'paypal_email_address');
                                                            paypal_email.setAttribute('value', details
                                                                .payer
                                                                .email_address);

                                                            var c_time = document.createElement(
                                                                "input");
                                                            c_time.setAttribute('type', 'text');
                                                            c_time.setAttribute('name', 'create_time');
                                                            c_time.setAttribute('value', details
                                                                .create_time);

                                                            var u_time = document.createElement(
                                                                "input");
                                                            u_time.setAttribute('type', 'text');
                                                            u_time.setAttribute('name', 'update_time');
                                                            u_time.setAttribute('value', details
                                                                .update_time);

                                                            var paypal_payer_name = document
                                                                .createElement(
                                                                    "input");
                                                            paypal_payer_name.setAttribute('type',
                                                                'text');
                                                            paypal_payer_name.setAttribute('name',
                                                                'paypal_payer_name');
                                                            paypal_payer_name.setAttribute('value',
                                                                details
                                                                .payer
                                                                .name
                                                                .given_name + " " +
                                                                details.payer.name.surname);

                                                            var amount = document.createElement(
                                                                "input");
                                                            amount.setAttribute('type', 'text');
                                                            amount.setAttribute('name', 'amount');
                                                            amount.setAttribute('value', details
                                                                .purchase_units[0]
                                                                .amount.value);

                                                            var address = document.createElement(
                                                                "input");
                                                            address.setAttribute('type', 'text');
                                                            address.setAttribute('name', 'address');
                                                            address.setAttribute('value', details
                                                                .purchase_units[0]
                                                                .shipping.address
                                                                .address_line_1 + "," + details
                                                                .purchase_units[
                                                                    0]
                                                                .shipping.address
                                                                .admin_area_1 + "," + details
                                                                .purchase_units[0]
                                                                .shipping.address
                                                                .admin_area_2);

                                                            myForm.appendChild(booking_id);
                                                            myForm.appendChild(vehicle_id);
                                                            myForm.appendChild(paypal_payer_id);
                                                            myForm
                                                                .appendChild(paypal_id);
                                                            myForm.appendChild(paypal_email);
                                                            myForm
                                                                .appendChild(c_time);
                                                            myForm.appendChild(u_time);
                                                            myForm.appendChild(
                                                                paypal_payer_name);
                                                            myForm.appendChild(amount);
                                                            myForm.appendChild(
                                                                address);

                                                            // console.log(myForm);

                                                            myForm.submit();
                                                        });
                                                    }
                                                }).render('#paypal{{ $reservation->booking_id }}');
                                                /* //This function displays Smart Payment Buttons on your web page. */
                                            </script>
                                        @else
                                            <div class="float-right d-inline-block">
                                                <span class="d-inline-block">Already paid</span>
                                                <i class="fas fa-check-double d-inline-block text-success"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                There are no reservations
                            @endforelse
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
