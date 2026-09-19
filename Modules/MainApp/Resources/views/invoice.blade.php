<!DOCTYPE html>
<html>

<head>
    <title>Payment Invoice</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap");

        body {
            font-family: "Libre Baskerville", serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
            line-height: 1.5;
            -webkit-print-color-adjust: exact !important;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin-top: 0;
            margin-bottom: .5rem;
        }

        .h1,
        .h2,
        .h3,
        .h4,
        .h5,
        .h6,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin-bottom: .5rem;
            font-weight: 500;
            line-height: 1.2;
        }

        p {
            font-size: 16px;
            font-weight: 400;
            line-height: 26px;
            color: #373737;
            margin-bottom: 0;
            font-family: "Libre Baskerville", serif;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }

        table {
            border-collapse: collapse;
        }

        *,
        ::after,
        ::before {
            box-sizing: border-box;
        }

        .table-light,
        .table-light>td,
        .table-light>th {
            background-color: #fdfdfe;
        }

        .invoice_wrapper {
            background: #F8F8F8;
        }

        .green_btn {
            border-radius: 8.04px;
            background: #25B900;
            text-transform: uppercase;
            border: 0;
            color: #FFF;
            font-family: Inter;
            font-size: 24.121px;
            font-style: normal;
            font-weight: 700;
            line-height: normal;
            padding: 12px 33px;
        }

        .invoice_wrapper_box {
            background: #FFF;
            box-shadow: 0px 8.04033px 48.24201px 0px rgba(0, 0, 0, 0.11);
            padding-bottom: 60px;
        }

        .invoice_wrapper_box .invoice_text {
            background: #392C7D;
            display: flex;
            justify-content: flex-end;
            height: 57px;
            padding-right: 140px;
            position: relative;
        }

        @media (max-width: 767.98px) {
            .invoice_wrapper_box .invoice_text {
                padding-right: 50px;
            }
        }



        @media (max-width: 767.98px) {
            .invoice_wrapper_box .invoice_text h3 {
                font-size: 24px;
                line-height: 57px;
            }
        }

        .invoice_wrapper_box_head {
            display: flex;
            justify-content: space-between;
            padding: 35px 0px;
        }

        .invoice_wrapper_box_head .invoice_wrapper_box_head_left h5 {
            color: #000;
            font-family: Inter;
            font-size: 20.101px;
            font-style: normal;
            font-weight: 400;
        }

        .invoice_wrapper_box_head .invoice_wrapper_box_head_left h3 {
            color: #333;
            font-family: Inter;
            font-size: 24px;
            font-style: normal;
            font-weight: 500;
            line-height: normal;
        }

        .invoice_wrapper_box_head .invoice_wrapper_box_head_right p {
            color: #666;
            font-family: Inter;
            font-size: 20.101px;
            font-style: normal;
            font-weight: 500;
            line-height: normal;
            margin-bottom: 10px;
        }

        .invoice_wrapper_box_head .invoice_wrapper_box_head_right p span {
            color: #333;
            font-family: Inter;
            font-size: 24px;
            font-style: normal;
            font-weight: 500;
            line-height: normal;
        }

        /* .invoice_wrapper_box_table table thead tr th {
  color: #242424;
  font-family: Inter;
  font-size: 20px;
  font-style: normal;
  font-weight: 500;
  line-height: normal;
  background: #EAEAEA;
  padding: 15.75px 32px;
  border: 0;
} */

        .invoice_wrapper_box_table table tbody tr td {
            color: #444;
            font-family: Inter;
            font-size: 18px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
            padding: 22.75px 32px;
            border-bottom: 2.01px solid #EAEAEA;
            border-top: 0;
        }



        .invoice_wrapper_box_total_count .invoice_wrapper_box_total_count_right .total_amount {
            font-size: 16px;
            margin-bottom: 20px;
        }






        .invoice_wrapper_box_body {
            padding: 0 44px;
        }

        @media (max-width: 767.98px) {
            .invoice_wrapper_box_body {
                padding: 30px;
            }
        }

        .download_btns {
            padding: 53px 0 38px 0;
        }

        /* new  */
        .row {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        @media (min-width: 1200px) {
            .col-xl-10 {
                -ms-flex: 0 0 83.333333%;
                flex: 0 0 83.333333%;
                max-width: 83.333333%;
            }
        }

        .justify-content-center {
            -ms-flex-pack: center !important;
            justify-content: center !important;
        }

        .justify-content-between {
            -ms-flex-pack: justify !important;
            justify-content: space-between !important;
        }

        .flex-wrap {
            -ms-flex-wrap: wrap !important;
            flex-wrap: wrap !important;
        }

        .d-flex {
            display: -ms-flexbox !important;
            display: flex !important;
        }

        @media (min-width: 1470px) {
            .container {
                max-width: 1464px;
                margin: 0 auto;
            }
        }

        .section_padding {
            padding: 120px 0px 90px 0;
        }
    </style>
</head>

<body>
    <div class="invoice_wrapper_box">
        <!-- invoice_wrapper_header  -->
        <div class="invoice_wrapper_header"
            style="padding: 20px 0; margin: 0 auto; display: flex; justify-content: space-between; flex-wrap: wrap; grid-gap: 20px;">
            <img height="60px" style="float: left;"
                src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path(setting('dark_logo')))) }}"
                alt="Logo">
            <button class="green_btn"
                style="float: right; border-radius: 8.04px; background: #25B900; text-transform: uppercase; border: 0; color: #FFF; font-family: Inter; font-size: 24.121px; font-style: normal; font-weight: 700; line-height: normal; padding: 12px 33px;">PAID</button>
        </div>
        <div class="invoice_text"
            style="margin-top: 50px; background: #392C7D; height: 56px; padding-right: 140px; position: relative; border-bottom: 7px solid #FF5170; text-align: right;">
            <h3
                style="font-size: 48px; font-weight: 700; color: #392C7D; background: #fff; display: inline-block; margin-bottom: 0; text-transform: uppercase; padding: 0 22px; position: relative; z-index: 2; line-height: 64px; height: 64px;">
                INVOICE</h3>
        </div>

        <div class="invoice_wrapper_box_body">
            <!-- invoice_wrapper_box_head  -->
            <div class="invoice_wrapper_box_head" style="">
                <!-- invoice_wrapper_box_head_left  -->
                <div class="invoice_wrapper_box_head_left" style="float: left; margin-bottom: 50px">
                    <h5
                        style="color: #333; font-family: Inter; font-size: 24px; font-style: normal; font-weight: 500; line-height: normal;">
                        Invoice To</h5>
                    <h3
                        style="color: #333; font-family: Inter; font-size: 32px; font-style: normal; font-weight: 500; line-height: normal;">
                        {{ @$data['to_name'] }}</h3>
                    <div class="contact_info_item" style="display: flex; align-items: center; grid-gap: 12px;">
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_4921_27621)">
                                <path
                                    d="M21.1718 16.8674V20.3097C21.1719 20.5562 21.0785 20.7935 20.9105 20.9738C20.7424 21.1542 20.5123 21.264 20.2664 21.2813C19.841 21.3105 19.4934 21.3261 19.2247 21.3261C10.6217 21.3261 3.64844 14.3528 3.64844 5.74977C3.64844 5.48108 3.66304 5.13353 3.69322 4.70811C3.71047 4.46224 3.82034 4.23207 4.00066 4.06404C4.18098 3.896 4.41832 3.80262 4.66479 3.80273H8.10715C8.22791 3.80261 8.34439 3.84738 8.43399 3.92834C8.52358 4.0093 8.57989 4.12067 8.59196 4.24082C8.61435 4.46473 8.6348 4.64288 8.65427 4.7782C8.84774 6.1284 9.24422 7.44158 9.83028 8.67325C9.92276 8.86795 9.86241 9.10062 9.68717 9.22523L7.58632 10.7264C8.87083 13.7194 11.256 16.1046 14.2491 17.3892L15.7483 15.2922C15.8096 15.2065 15.899 15.1451 16.0009 15.1186C16.1029 15.0921 16.2109 15.1022 16.3061 15.1471C17.5376 15.7321 18.8505 16.1276 20.2002 16.3202C20.3355 16.3397 20.5137 16.3611 20.7356 16.3825C20.8556 16.3948 20.9667 16.4512 21.0475 16.5408C21.1283 16.6304 21.1729 16.7467 21.1727 16.8674H21.1718Z"
                                    fill="#666666" />
                            </g>
                            <defs>
                                <clipPath id="clip0_4921_27621">
                                    <rect width="23.3644" height="23.3644" fill="white"
                                        transform="translate(0.726562 0.882324)" />
                                </clipPath>
                            </defs>
                        </svg>
                        <p
                            style="color: #666; font-family: Inter; font-size: 24.121px; font-style: normal; font-weight: 400; line-height: normal ; margin:0">
                            {{ @$data['to_phone'] }}</p>
                    </div>
                    <div class="contact_info_item" style="display: flex; align-items: center; grid-gap: 12px;">
                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M3.64539 3.14697H21.1687C21.4269 3.14697 21.6745 3.24954 21.8571 3.43211C22.0397 3.61468 22.1422 3.8623 22.1422 4.12049V19.6968C22.1422 19.955 22.0397 20.2026 21.8571 20.3852C21.6745 20.5677 21.4269 20.6703 21.1687 20.6703H3.64539C3.3872 20.6703 3.13958 20.5677 2.95701 20.3852C2.77444 20.2026 2.67188 19.955 2.67188 19.6968V4.12049C2.67188 3.8623 2.77444 3.61468 2.95701 3.43211C3.13958 3.24954 3.3872 3.14697 3.64539 3.14697V3.14697ZM20.1952 7.27274L12.4772 14.1847L4.61891 7.25133V18.7233H20.1952V7.27274ZM5.11638 5.09401L12.4664 11.5796L19.7104 5.09401H5.11638Z"
                                fill="#666666" />
                        </svg>
                        <p
                            style="color: #666; font-family: Inter; font-size: 24.121px; font-style: normal; font-weight: 400; line-height: normal; margin:0">
                            {{ @$data['to_email'] }}</p>
                    </div>
                </div>

                <div class="invoice_wrapper_box_head_right" style="float: right">
                    <p>Invoice No:
                        <span>
                            @if (@$data['invoice_no'] < 10)
                                00000{{ @$data['invoice_no'] }}
                            @elseif (@$data['invoice_no'] < 100)
                                0000{{ @$data['invoice_no'] }}
                            @elseif (@$data['invoice_no'] < 1000)
                                000{{ @$data['invoice_no'] }}
                            @elseif (@$data['invoice_no'] < 10000)
                                00{{ @$data['invoice_no'] }}
                            @else
                                {{ @$data['invoice_no'] }}
                            @endif
                        </span>
                    </p>
                    <p>Invoice Date: <span>{{ date('d M Y') }}</span></p>
                </div>
            </div>
            <!-- invoice_wrapper_box_table  -->
            <div class="invoice_wrapper_box_table table-responsive" style="margin-top:150px">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th
                                style="color: #242424; font-family: Inter; font-size: 20px; font-style: normal; font-weight: 500; line-height: normal; background: #EAEAEA; padding: 15.75px 32px; border: 0;">
                                SL</th>
                            <th
                                style="color: #242424; font-family: Inter; font-size: 20px; font-style: normal; font-weight: 500; line-height: normal; background: #EAEAEA; padding: 15.75px 32px; border: 0;">
                                ITEM DESCRIPTION</th>
                            <th
                                style="color: #242424; font-family: Inter; font-size: 20px; font-style: normal; font-weight: 500; line-height: normal; background: #EAEAEA; padding: 15.75px 32px; border: 0;">
                                TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>01</td>
                            <td>{{ @$data['package_name'] }}- Subscription ({{ date('d M Y') }}-

                                @if (@$data['package_duration'] == 1)
                                    <span>{{ date('d M Y', strtotime('+ ' . @$data['package_duration_number'] . ' day')) }}</span>
                                @elseif (@$data['package_duration'] == 2)
                                    <span>{{ date('d M Y', strtotime('+ ' . @$data['package_duration_number'] . ' month')) }}</span>
                                @elseif (@$data['package_duration'] == 3)
                                    <span>{{ date('d M Y', strtotime('+ ' . @$data['package_duration_number'] . ' year')) }}</span>
                                @else
                                    <span>Lifetime</span>
                                @endif

                                )
                            </td>
                            <td>${{ @$data['package_amount'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="invoice_wrapper_box_total_count" style="margin-top: 32px;">
                <div class="invoice_wrapper_box_total_count_left"
                    style="float: left; color: #333; font-family: Inter; font-size: 22.111px; font-style: normal; font-weight: 500; line-height: normal; display: inline-block; margin-right: 16px; width: 50%;">
                    @php
                        $formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
                        $inWords = $formatter->format(@$data['package_amount']);
                    @endphp
                    <p
                        style="color: #666; font-family: Inter; font-size: 22.111px; font-style: normal; font-weight: 400; line-height: normal;">
                        <span>In word:</span>{{ $inWords }} dollar.
                    </p>
                </div>
                <div class="invoice_wrapper_box_total_count_right"
                    style="float: right; color: #333; font-family: Inter; font-size: 18px; font-style: normal; font-weight: 400; line-height: normal; max-width: 311.563px; width: 50%;">
                    <p
                        style="display: flex; align-items: center; margin-bottom: 8px; color: #333; font-family: Inter; font-size: 18px; font-style: normal; font-weight: 400; line-height: normal;">
                        <span class="f_w_500 max_left" style="max-width: 100px; width: 100%; flex-shrink: 0;">Sub Total
                            :</span>
                        <span class="total_price"
                            style="color: #333; font-family: Inter; font-size: 24px; font-style: normal; font-weight: 500; line-height: normal;">${{ @$data['package_amount'] }}
                            USD</span>
                    </p>
                    <p
                        style="color: #333; font-family: Inter; font-size: 18px; font-style: normal; font-weight: 400; line-height: normal;">
                        <span class="max_left" style="max-width: 100px; width: 100%; flex-shrink: 0;">Paid:</span>
                        <span class="total_price"
                            style="color: #333; font-family: Inter; font-size: 24px; font-style: normal; font-weight: 500; line-height: normal;">${{ @$data['package_amount'] }}
                            USD</span>
                    </p>
                    <div class="total_amount"
                        style="background: #392C7D; color: #FFF; font-family: Inter; font-size: 24.121px; font-style: normal; font-weight: 500; line-height: normal; padding: 12px 12px; margin-top: 16px;">
                        TOTAL : ${{ @$data['package_amount'] }} USD
                    </div>
                </div>
            </div>

            <div class="payment_method_type" style="max-width: 160px; margin-top: 160px">
                <h4
                    style=" margin:0;color: #333; font-family: Inter; font-size: 17.229px; font-style: normal; font-weight: 500; line-height: normal; border-bottom: 1.436px solid #BEBEBE; padding-bottom: 8px; margin-bottom: 12px;">
                    Payment Method: {{ @$data['payment_method'] }}</h4>
                <h5
                    style="margin:0; color: #333; font-family: Inter; font-size: 20.101px; font-style: normal; font-weight: 400; line-height: 27.28px;">
                    Bank Transfer</h5>
            </div>

            <div class="payment_terms" style="display: flex; flex-direction: column;">
                <h5
                    style="color: #333; font-family: Inter; font-size: 12.608px; font-style: normal; font-weight: 500; line-height: normal; display: inline-block; padding: 0 16px 6px 0; border-bottom: 1.051px solid #BEBEBE; margin-top: 10px;">
                    Payment Terms:</h5>
                <p
                    style="color: #666; font-family: Inter; font-size: 10.709px; font-style: normal; font-weight: 500; line-height: 16.659px;">
                    * Payment is due within 30 days from the invoice date unless otherwise agreed upon in writing</p>
                <p
                    style="color: #666; font-family: Inter; font-size: 10.709px; font-style: normal; font-weight: 500; line-height: 16.659px;">
                    * Accepted payment methods include bank transfer, credit card, or PayPal.</p>
            </div>

            {{-- @dd('sdfsdf') --}}

        </div>
    </div>
</body>

</html>
