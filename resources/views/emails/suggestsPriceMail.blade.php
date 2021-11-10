<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>
</head>
<body>
    <h5>User name: {{  $details['user_name'] }}</h5>
    <h5>User email: {{ $details['user_email'] }}</h5>
    <h5>Property address: {{  $details['property_address'] }}</h5>
    <h5>Suggests price: {{ $details['price'] }} {!! $details['currency_type_symbol'] !!}</h5>
    @if($details['end_time'])
        <h5>Suggests price end time: {{ $details['end_time'] }}</h5>
    @endif
    
</body>
</html>