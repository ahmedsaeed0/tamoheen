<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trip Cancellation Email</title>
</head>

<body>
    <p><strong>Cancellation Date:</strong> {{ $cancellationDate }}</p>
    <p><strong>Trip Information:</strong></p>
    <ul>
        <li><strong>Trip Date:</strong> {{ $tripStartDate }}</li>
        <li><strong>Start Point:</strong> {{ $trip_start }}</li>
        <li><strong>End Point:</strong> {{ $trip_end }}</li>
        <li><strong>Brand Name:</strong> {{ $brand_name }}</li>
        <li><strong>Driver Name:</strong> {{ $driver_name }}</li>
    </ul>
    <p><strong>Canceled By:</strong> {{ $canceledBy }}</p>

    <span>
        <h3>customer canceled his trip for emeregency ,please make discuont to attrcat new cutsomers.</h3>
    </span>
</body>

</html>