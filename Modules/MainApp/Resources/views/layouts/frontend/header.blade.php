<!doctype html>
<!--( class="rtl" dir="rtl" ) => add this for rtl  -->
<html   class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ setting('application_name') }}</title>
    <meta name="description" content="{{ setting('application_name') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <meta name="csrf-token" content="{{ csrf_token() }}">
    <input type="hidden" name="url" id="headerID" value="{{ url('') }}">

    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">

    <!-- CSS here -->
    <!-- commit wthen need rtl  -->
    <link rel="stylesheet" href="{{ asset('saas-frontend') }}/css/bootstrap.min.css">
    <!-- uncommit for rtl  -->
    <!-- <link rel="stylesheet" href="{{ asset('saas-frontend') }}/css/bootstrap-rtl.min.css"> -->
    <link rel="stylesheet" href="{{ asset('saas-frontend') }}/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset('saas-frontend') }}/css/magnific-popup.css">
    <link rel="stylesheet" href="{{ asset('saas-frontend') }}/css/fontawesome.css ">
    <link rel="stylesheet" href="{{ asset('saas-frontend') }}/css/themify-icons.css">
    <link rel="stylesheet" href="{{ asset('saas-frontend') }}/css/flaticon.css">
    <link rel="stylesheet" href="{{ asset('saas-frontend') }}/css/nice-select.css">
    <link rel="stylesheet" href="{{ asset('saas-frontend') }}/css/animate.min.css">
    <link rel="stylesheet" href="{{ asset('saas-frontend') }}/css/slicknav.css">
    <link rel="stylesheet" href="{{ asset('saas-frontend') }}/js/vendor/calender_js/core/main.css">
    <link rel="stylesheet" href="{{ asset('saas-frontend') }}/js/vendor/calender_js/daygrid/main.css">
    <link rel="stylesheet" href="{{ asset('saas-frontend') }}/js/vendor/calender_js/timegrid/main.css">
    <link rel="stylesheet" href="{{ asset('saas-frontend') }}/js/vendor/calender_js/list/main.css">
    <link rel="stylesheet" href="{{ asset('saas-frontend') }}/css/style.css">
    <link rel="stylesheet" href="{{asset('frontend')}}/css/sweetalert2.min.css">

</head>

<body>
