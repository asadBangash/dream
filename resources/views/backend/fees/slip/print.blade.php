<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Fee Slip — {{ $slip['student']['name'] }}</title>
    @include('backend.fees.slip._styles')
</head>
<body onload="window.print()">
    @include('backend.fees.slip._body', ['slip' => $slip])
</body>
</html>
