@extends('installer::layouts.app_install', ['title' => @$data['title']])
@section('title', $data['title'])

@section('content')

    <!-- from section -->

    <form class="pb-3" data-parsley-validate method="post" action="{{ route('service.license_post') }}" id="content_form">
        @csrf

        <div class="mb-3 px-5 pt-5">
            <label class="form-label" for="access_code"><b>{{ ___('installer.Purchase Code') }}
                    <span class="star">*</span>
                </b></label>
            <input type="text" name="access_code" id="access_code" class="form-control" required="required" autofocus=""
                value="{{ old('access_code', request('access_code')) }}" placeholder="{{ ___('installer.Purchase Code') }}" />
            <small class="mt-2">
                {{ ___('installer. NB:Enter your purchase code to verify your license, the temporary code for your license is') }}
                <strong>123-456-789</strong>
            </small>

            @if (request('message'))
                <span class="text-danger">{{ request('message') }}</span>
            @endif
        </div>
        <div class="mb-3 px-5">
            <label class="form-label" for="envato_email"><b>{{ ___('installer.Envato Email') }}<span
                        class="star">*</span></b></label>
            <input type="email" class="form-control" data-parsley-type="email" name="envato_email" id="envato_email"
                value="{{ old('envato_email', request('envato_email')) }}" required="email"
                placeholder="{{ ___('installer.Envato Email') }}">

            <small class="mt-2">
                {{ ___('installer. NB: To verify your authorization, use your Envato account email address') }}</small>


        </div>
        <div class="mb-3 px-5 pb-3">
            <label class="form-label" for="installed_domain"><b>{{ ___('installer.Installed Domain') }}<span
                        class="star">*</span></b></label>
            <input type="text" class="form-control" name="installed_domain" id="installed_domain" required="required"
                value="{{ url('/') }}">
            <small class="mt-2">
                {{ ___('installer. NB: What domain or subdomain are you using to access this project?') }}
                {{ ___('installer. It depends on whether you want to install this project in the main domain like') }}
                example.com {{ ___('installer.or in a subdomain like ') }} sub.example.com </small>
        </div>
        @if ($reinstall)
            <div class="form-group">
                <label data-id="bg_option" class="primary_checkbox d-flex mr-12 ">
                    <input name="re_install" type="checkbox">
                    <span class="checkmark"></span>
                    <span class="ml-2">{{ ___('installer.Re-install System') }}</span>
                </label>
            </div>
        @endif
        <div class="px-5 pb-4 d-flex flex-column  gap-3">

            <div class="d-flex justify-content-center mt-4">
                <button type="submit"
                    class="btn color mb-3 btn-primary px-5 py-3 align-items-start follow-next-step submit">
                    {{ @$data['button_text'] }} </button>
            </div>
            <button type="button" class="btn color btn-primary px-5 py-3 align-items-start follow-next-step submitting"
                disabled style="display:none"> <b>{{ ___('installer.Submitting') }}</b> </button>
        </div>

    </form>

@stop
@push('js')
    <script>
        _formValidation('content_form');
        $(document).ready(function() {
            setTimeout(function() {
                $('.preloader h2').text('Wait for a moment...');
            }, 2000);
        })
    </script>
@endpush
