<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Fee Slip</title>
    @include('backend.fees.slip._styles')
</head>
<body>
    @include('backend.fees.slip._body', ['slip' => $slip])
</body>
</html>
