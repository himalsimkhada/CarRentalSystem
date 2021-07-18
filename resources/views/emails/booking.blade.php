<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Online Car Rental - Mail</title>
</head>

<body>
    <h3>Hello, {{ auth()->user()->username }}</h3>
    <p>Thank you for booking the vehicle. Please follow the procedure and please kindly pay in time.</p>
    <p>Please look at the details of your booking carefully and if there is some wrong informations then you can kindly contact us. We will try our best to help you.</p>

    <ul style="list-style-type: none">
        <li>Date: {{ $booking['booking_date'] }}</li>
        <li>Pick Up Date: {{ $booking['date'] }}</li>
        <li>Return Date: {{ $booking['return_date'] }}</li>
        <li>Final Cost: {{ $booking['final_cost'] }}</li>
        <small>Final cost is calculated from multiplying the per day cost with the date you choosed.</small>
    </ul>

    <p>Thank you</p>
</body>

</html>
