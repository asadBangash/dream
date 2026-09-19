@extends('installer::layouts.app_install', ['title' => @$data['title']])
@section('title', $data['title'])
@section('content')

    <!-- from section -->
    <form class="pb-3" method="post" action="{{ route('service.database_post') }}" id="content_form">
        <div class="mb-3 px-5 mt-3">
            <label class="form-label" class="required" for="db_host"><b>{{ @$data['DB HOST'] }}<span
                        class="star">*</span></b></label>
            <input type="text" class="form-control" name="db_host" id="db_host" required="required"
                placeholder="{{ __('127.0.0.1') }}" value="localhost" />
        </div>
        <div class="mb-3 px-5">
            <label class="form-label" for="db_port"><b>{{ @$data['DB PORT'] }}<span class="star">*</span></b></label>
            <input type="text" class="form-control" name="db_port" id="db_port" required="required"
                placeholder="{{ __('3306') }}" value="3306">
        </div>
        <div class="mb-3 px-5 pb-3">
            <label class="form-label" for="db_database"><b>{{ @$data['DB DATABASE'] }}<span
                        class="star">*</span></b></label>
            <input type="text" class="form-control" name="db_database" id="db_database" required="required"
                placeholder="{{ ___('installer.Write DB Name') }}" autofocus="" value="{{ env('DB_DATABASE') }}">
        </div>
        <div class="mb-3 px-5">
            <label class="form-label" for="db_username"><b>{{ @$data['DB USERNAME'] }}<span
                        class="star">*</span></b></label>
            <input type="text" class="form-control" name="db_username" id="db_username" required="required"
                placeholder="{{ ___('installer.Write DB Username') }}" value="{{ env('DB_USERNAME') }}">
        </div>
        <div class="mb-3 px-5 pb-3">
            <label class="form-label"><b>{{ @$data['DB PASSWORD'] }}</b></label>
            <input type="password" class="form-control" name="db_password" id="db_password"
                placeholder="{{ ___('installer.Write DB Password') }}" value="{{ env('DB_PASSWORD') }}">

        </div>
        <div class="px-5 pb-4 d-flex align-items-center gap-2 d-none">
            <input class="form-check-input" type="checkbox" name="force_migrate" id="flexRadioDefault2" checked />
            <label class="form-check-label" for="flexRadioDefault2">
                {{ @$data['Force Delete Previous Table'] }}
            </label>
        </div>

        <div class="px-5 pb-4 d-flex justify-content-center align-items-center flex-column  gap-3">


            <div class="d-flex justify-content-between mt-4">
                <button type="submit"
                    class="btn color mb-3 btn-primary px-5 py-3 align-items-start follow-next-step submit">{{ @$data['button_text'] }}</button>
            </div>
            <button type="button" class="btn color btn-primary px-5 py-3 align-items-start follow-next-step submitting"
                disabled style="display:none">{{ ___('installer.submitting') }}</button>
        </div>

    </form>
@stop
@push('js')
    <script>
        _formValidation('content_form');
        $(document).ready(function() {
            setTimeout(function() {
                $('.preloader h2').text('{{ ___('installer.Please wait...') }}');
            }, 2000);
        });
    </script>
@endpush
