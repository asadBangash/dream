<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <title>Stripe Payment</title>


    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100vh;
        }

        .form-wrapper {
            min-width: 300px;
            max-width: 400px;
        }

        .form-header {
            display: flex;
            align-items: center;
            justify-content: space-between
        }

        .logo {
            width: 100px;
        }
        
        #checkout-form {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .back-icon {
            display: flex;
            align-items: center;
            gap: 2px;
            font-size: 14px;
            text-decoration: none;
            color: black;
            padding: 5px 8px;
        }

        .back-icon:hover {
            background: #efefef;
            border-radius: 10px;
        }

        .back-icon svg {
            width: 20px;
        }

        #card-element {
            border: 2px solid #635BFF;
            padding-block: 10px;
            padding-left: 16px;
            padding-right: 5px;
            border-radius: 10px;
        }

        button {
            padding: 10px 6px;
            border: none;
            background: transparent;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            border-radius: 10px;
        }

        .btn-primary {
            background: #635BFF;
            color: #ffffff
        }

        .btn-primary:hover {
            background: #5d55ff;
        }
    </style>
</head>
<body>
    @php
        $amount = $feeAssignChildren->feesMaster?->amount;
        $fineAmount = 0;
        if (date('Y-m-d') > $feeAssignChildren->feesMaster?->due_date && $feeAssignChildren->fees_collect_count == 0) {
            $fineAmount = $feeAssignChildren->feesMaster?->fine_amount;
            $amount += $fineAmount;
        }                      
    @endphp

    <div class="container">
        <div class="form-wrapper">
            <form action="{{ route('student-fees.pay-with-stripe.store') }}" method="POST" id="checkout-form">
                @csrf
                <input type="hidden" name="fees_assign_children_id" value="{{ $feeAssignChildren->id }}">
                <input type="hidden" name="student_id" value="{{ $feeAssignChildren->student_id }}">
                <input type="hidden" name="amount" value="{{ $amount - $fineAmount }}">
                <input type="hidden" name="fine_amount" value="{{ $fineAmount }}">

                <div class="form-header">
                    <img class="logo" src="{{ asset('images/stripe.png') }}" alt="stripe">
                    <a href="{{ route('student-fees.payment-cancel') }}" class="back-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M7.82843 10.9999H20V12.9999H7.82843L13.1924 18.3638L11.7782 19.778L4 11.9999L11.7782 4.22168L13.1924 5.63589L7.82843 10.9999Z"></path></svg>
                        <span>Back</span>
                    </a>
                </div>
                <input type='hidden' name='stripeToken' id='stripe-token-id'>
                <div id="card-element"></div>
                <button type="button" onclick="createToken()" class="btn-primary" id='stripe-pay-btn'>Pay {{ $amount }}{{ Setting('currency_symbol') }}</button>
            </form>
        </div>
    </div>

    <script src="{{ global_asset('backend') }}/assets/js/jquery-3.6.0.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    @include('common.fee-pay.fee-pay-script')
</body>
</html>