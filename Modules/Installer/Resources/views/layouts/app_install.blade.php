<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ env('APP_NAME') }} || @yield('title') </title>
    <link rel="shortcut icon" href="{{ asset($data['asset_path'] . '/images/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset($data['asset_path'] . '/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset($data['asset_path'] . '/css/style.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="base_url" content="{{ url('/') }}" />
    <meta name="goto_url" content="{{ route('service.import_sql') }}" />
    <!-- installer master css -->
</head>

<body>
    <div class="preloader">
        <div class="loader_img">
            <img src="{{ $data['asset_path'] }}/loader.gif" alt="loading..." height="200" width="200">
            <h2>{{ __('Please Wait...') }}</h2>
        </div>
    </div>
    <div class=" installer-container">

        <div class="padding-left-top installer-container__left">

            <a href="{{ url('/') }}" class="img-tag white">
                <img src="{{ asset($data['asset_path'] . '/images/logo.png') }}" alt="logo">
            </a>

            <div class="mt-5 pe-2 follow-next-step-side" step-count="1">
                <div class="d-flex align-items-center gap-3">
                    <div
                        class="p-3 step-with-border @if (session('WelcomeNote')) completed @else initial @endif  rounded-circle d-flex flex-column justify-content-center align-items-center image-icon tab-button">
                        <img src="{{ $data['asset_path'] }}/images/check-mark.svg" alt="" />
                    </div>
                    <div>
                        <p>{{ __('01.') }}</p>
                        <h5><b>{{ __('Welcome Note') }}</b></h5>
                    </div>
                </div>
                <span class="next-step-status-line"></span>
            </div>
            <div class="pe-4 follow-next-step-side" step-count="2">
                <div class="d-flex align-items-center gap-3">
                    <div
                        class="p-3 border step-with-border @if (session('CheckEnvironment')) completed @else initial @endif  rounded-circle d-flex flex-column justify-content-center align-items-center image-icon tab-button">
                        <img src="{{ $data['asset_path'] }}/images/check-mark.svg" alt="" />
                    </div>
                    <div class="col-9">
                        <p>{{ __('02.') }}</p>
                        <h5><b>{{ __('Check Environment') }}</b></h5>
                    </div>
                </div>
                <span class="next-step-status-line"></span>
            </div>
            <div class="pe-4 follow-next-step-side" step-count="3">
                <div class="d-flex align-items-center gap-3">
                    <div
                        class="border step-with-border  @if (session('LicenseVerification')) completed @else initial @endif   rounded-circle d-flex flex-column justify-content-center align-items-center image-icon tab-button">
                        <img src="{{ $data['asset_path'] }}/images/check-mark.svg" alt="" />
                    </div>
                    <div class="ps-2">
                        <p>{{ __('03.') }}</p>
                        <h5><b>{{ __('Licence Verification') }}</b></h5>
                    </div>
                </div>
                <span class="next-step-status-line"></span>
            </div>
            <div class="pe-4 follow-next-step-side" step-count="4">
                <div class="d-flex align-items-center gap-3">
                    <div
                        class="p-3 border step-with-border @if (session('DatabaseSetup')) completed @else initial @endif  rounded-circle d-flex flex-column justify-content-center align-items-center image-icon tab-button">
                        <img src="{{ $data['asset_path'] }}/images/check-mark.svg" alt="" />
                    </div>
                    <div class="col-9">
                        <p>{{ __('04.') }}</p>
                        <h5><b>{{ __('Database Setup') }}</b></h5>
                    </div>
                </div>
                <span class="next-step-status-line"></span>
            </div>
            <div class="pe-4 follow-next-step-side" step-count="5">
                <div class="d-flex align-items-center gap-3">
                    <div
                        class="p-3 border step-with-border  @if (session('AdminSetup')) completed @else initial @endif  rounded-circle d-flex flex-column justify-content-center align-items-center image-icon tab-button">
                        <img src="{{ $data['asset_path'] }}/images/check-mark.svg" alt="" />
                    </div>
                    <div class="ps-2">
                        <p>{{ __('05.') }}</p>
                        <h5><b>{{ __('Admin Setup & Import SQL') }}</b></h5>
                    </div>
                </div>
                <span class="next-step-status-line"></span>
            </div>
            <div class="pe-4 follow-next-step-side" step-count="6">
                <div class="d-flex align-items-center gap-3">
                    <div
                        class="p-3 border step-with-border  @if (session('Complete')) completed @else initial @endif  rounded-circle d-flex flex-column justify-content-center align-items-center image-icon tab-button">
                        <img src="{{ $data['asset_path'] }}/images/icon-white/complete.svg" alt="" />
                    </div>
                    <div>
                        <p>{{ __('06.') }}</p>
                        <h5><b>{{ __('Complete') }}</b></h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="from-section  d-flex align-item-center justify-content-center">
            <div class="bg-white from-section__main  rounded show-section tab-section">
                <div class="bg-white content-section-width w-100 rounded" step-count="4">
                    <div class="text-title p-3 text-center text-white">
                        <h3>{{ @$data['title'] }}</h3>
                    </div>
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{ $data['asset_path'] }}/js/jquery-3.7.0.min.js"></script>
    <script type="text/javascript" src="{{ $data['asset_path'] }}/js/bootstrap.bundle.min.js"></script>
    <script src="{{ $data['asset_path'] }}/js/sweetalert2.min.js"></script>
    <script src="{{ $data['asset_path'] }}/js/parsley.min.js"></script>
    <script src="{{ $data['asset_path'] }}/js/function.js"></script>
    <script src="{{ $data['asset_path'] }}/js/common.js"></script>

    @if (Session::has('success'))
        <script>
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: '{{ Session::get('success') }}'
            })
        </script>
    @endif
    @if (Session::has('danger'))
        <script>
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'error',
                title: '{{ Session::get('danger') }}'
            })
        </script>
    @endif
    @if (Session::has('warning'))
        <script>
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'warning',
                title: '{{ Session::get('warning') }}'
            })
        </script>
    @endif

    @stack('js')
</body>

</html>
