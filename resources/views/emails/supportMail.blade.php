<!DOCTYPE html>
<html>
<head>
    <title>Estate</title>
</head>
<body>
    @if($details['title'])
     <h1>{{ $details['title'] }}</h1>
    @endif
    <p>{{ $details['body'] }}</p>
   
    <p>Thank you</p>
</body>
</html>