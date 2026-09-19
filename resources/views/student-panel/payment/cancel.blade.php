<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <title>Success</title>

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            color: #EC252B;
        }
        .container {
            min-width: 300px;
            max-width: 400px;
            margin: 0 auto;
            width: 100%;
            height: 90vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0;
        }

        h2 {
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="{{ asset('images/cancel.gif') }}" alt="cancel">
        <h2>Payment Cancelled</h2>
    </div>
</body>
</html>