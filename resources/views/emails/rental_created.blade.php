<!DOCTYPE html>
<html>

<head>
    <title>Rental Confirmation</title>
</head>

<body>
    <h1>Your Car Rental Confirmation</h1>
    <p>Dear {{ $rental->user->name }},</p>
    <p>Your rental for the car <strong>{{ $rental->car->name }}</strong> has been successfully created.</p>
    <p><strong>Start Date:</strong> {{ $rental->start_date }}</p>
    <p><strong>End Date:</strong> {{ $rental->end_date }}</p>
    <p><strong>Total Cost:</strong> ${{ $rental->total_cost }}</p>
    <p>Thank you for using our service!</p>
</body>

</html>