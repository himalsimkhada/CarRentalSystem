<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Online Car Rental System - Mail</title>
</head>
<body>
    <h3>Hello, {{ auth()->user()->username }}</h3>
    <p>We are glad that you chose our service. This is the payment mail, which contains informations about your payment.</p>

    <ul style="list-style-type: none;">
        <li>Transaction ID: {{ $invoice['transaction_id'] }}</li>
        <li>Paypal Payer ID: {{ $invoice['paypal_payer_id'] }}</li>
        <li>Email Address: {{ $invoice['paypal_email_address'] }}</li>
        <li>Payer Name: {{ $invoice['paypal_payer_name'] }}</li>
        <li>Amount Paid: $<b>{{ $invoice['amount'] }}</b></li>
    </ul>

    <p>Thank you for your payment.</p>
</body>
</html>
