<!DOCTYPE html>
<html>
<head>
    <title>Affiliate Registration</title>
</head>
<body>
    <h1>Welcome, {{ $affiliate->user->name }}!</h1>
    <p>You have successfully registered as an affiliate for {{ $affiliate->merchant->display_name }}.</p>
    <p>Your commission rate: {{ $affiliate->commission_rate }}%</p>
</body>
</html>
