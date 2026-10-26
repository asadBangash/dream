<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Fee Slips</title>
    @include('backend.fees.slip._styles')
</head>
<body onload="window.print()">
    @foreach ($slips as $index => $slip)
        @include('backend.fees.slip._body', ['slip' => $slip])
        @if ($index < count($slips) - 1)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>
</html>
