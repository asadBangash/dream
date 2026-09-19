@extends('mainapp::layouts.backend.master')

@section('title')
{{ @$data['title'] }}
@endsection

@section('content')
    <div class="page-content">

        {{-- bradecrumb Area S t a r t --}}
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="bradecrumb-title mb-1">{{ $data['title'] }}</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ ___('mainapp_common.home') }}</a></li>
                        <li class="breadcrumb-item">{{ $data['title'] }}</li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-header">
                <h4>{{ ___('main_settings.General Settings') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('settings.general-settings') }}" enctype="multipart/form-data" method="post"
                    id="visitForm">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="row mb-3">
                                <!--Application Name Start -->
                                <div class="col-12 col-md-6 col-xl-6 col-lg-6 mb-3 ">
                                    <label for="inputname" class="form-label">{{ ___('main_settings.Application name') }} <span
                                            class="fillable">*</span></label>
                                    <input type="text" name="application_name"
                                        class="form-control ot-input @error('application_name') is-invalid @enderror"
                                        value="{{ Setting('application_name') }}"
                                        placeholder="{{ ___('main_settings.enter you application name') }}">
                                    @error('application_name')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <!--Application Name End -->
                                <!--Footer Text Start -->
                                <div class="col-12 col-md-6 col-xl-6 col-lg-6 mb-3 ">
                                    <label for="inputname" class="form-label">{{ ___('main_settings.Footer text') }} <span
                                            class="fillable">*</span></label>
                                    <input type="text" name="footer_text"
                                        class="form-control ot-input @error('footer_text') is-invalid @enderror"
                                        value="{{ Setting('footer_text') }}"
                                        placeholder="{{ ___('main_settings.enter your footer text') }}">
                                    @error('footer_text')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-md-6 col-xl-6 col-lg-6 mb-3">
                                    <label class="form-label" for="light_logo">{{ ___('main_settings.Light logo') }} {{ ___('mainapp_common.(155 x 40 px)') }}</label>
                                    <br>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img class="img-thumbnail mb-10 ot-input full-logo setting-image"
                                            src="{{ @globalAsset(setting('light_logo'), '154X38.webp') }}"
                                            alt="{{ __('light logo') }}">
                                    </div>

                                    {{-- File Uplode --}}
                                    <div class="ot_fileUploader left-side mb-3">
                                        <input class="form-control" type="text" placeholder="{{ ___('main_settings.browse light logo') }}" readonly="" id="placeholder">
                                        <button class="primary-btn-small-input" type="button">
                                            <label class="btn btn-lg ot-btn-primary" for="fileBrouse">{{ ___('mainapp_common.browse') }}</label>
                                            <input type="file" class="d-none form-control" name="light_logo" id="fileBrouse" accept="image/*">
                                        </button>
                                    </div>
                                </div>
                                <!--White Logo End -->
                                <!--Black Logo Start -->
                                <div class="col-12 col-md-6 col-xl-6 col-lg-6 ">
                                    <label class="form-label" for="dark_logo">{{ ___('main_settings.Dark logo') }} {{ ___('mainapp_common.(155 x 40 px)') }}</label>
                                    <br>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img class="img-thumbnail mb-10 ot-input full-logo setting-image"
                                            src="{{ @globalAsset(setting('dark_logo'), '154X38.webp') }}"
                                            alt="{{ __('dark logo') }}">
                                    </div>
                                    {{-- File Uplode --}}
                                    <div class="ot_fileUploader left-side mb-3">
                                        <input class="form-control" type="text" placeholder="{{ ___('main_settings.browse dark logo') }}" readonly="" id="placeholder2">
                                        <button class="primary-btn-small-input" type="button">
                                            <label class="btn btn-lg ot-btn-primary" for="fileBrouse2">{{ ___('mainapp_common.browse') }}</label>
                                            <input type="file" class="d-none form-control" name="dark_logo" id="fileBrouse2" accept="image/*">
                                        </button>
                                    </div>
                                </div>
                                <!--Black Logo End -->
                                <div class="col-12">
                                    <div class="">
                                        <div class="row align-items-end">
                                            <!--Favicon Start -->
                                            <div class="col-md-6 favicon-uploader">
                                                <div class="d-flex flex-column">
                                                    <label class="form-label"
                                                        for="favicon">{{ ___('main_settings.Favicon') }} {{ ___('mainapp_common.(40 x 40 px)') }}</label>
                                                    <br>
                                                    <div class="d-flex align-items-center gap-3 justify-content-center">
                                                        <img class="img-thumbnail mb-10 ot-input full-logo setting-image"
                                                            src="{{ @globalAsset(setting('favicon'), '40X40.webp') }}"
                                                            alt="{{ __('favicon') }}">
                                                    </div>
                                                    <div class="ot_fileUploader left-side mb-3">
                                                        <input class="form-control" type="text" placeholder="{{ ___('main_settings.browse favicon') }}" readonly="" id="placeholder3">
                                                        <button class="primary-btn-small-input" type="button">
                                                            <label class="btn btn-lg ot-btn-primary" for="fileBrouse3">{{ ___('mainapp_common.browse') }}</label>
                                                            <input type="file" class="d-none form-control" name="favicon" id="fileBrouse3" accept="image/*">
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Favicon End -->
                                            <!-- Default Langauge Start-->
                                            <div class="col-md-6 default-langauge mb-3">
                                                <div class="d-flex flex-column">
                                                    <label for="default langauge"
                                                        class="form-label">{{ ___('main_settings.Default Language') }} <span
                                                            class="fillable">*</span></label>
                                                    <select name="default_langauge" id="defaultlangaugeId"
                                                        class="form-select ot-input flag_icon_list @error('default_langauge') is-invalid @enderror">

                                                        @foreach ($data['languages'] as $row)
                                                            <option value="{{ $row->code }}"
                                                                data-icon="{{ $row->icon_class }}"
                                                                {{ Setting('default_langauge') == $row->code ? 'selected' : '' }}>
                                                                {{ $row->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Default Langauge End-->

                                            <!-- Currency Start-->
                                            <div class="col-md-6 default-langauge mb-3">
                                                <div class="d-flex flex-column">
                                                    <label for="currency_code" class="form-label">
                                                        {{ ___('settings.Currency') }}
                                                        <span class="fillable">*</span>
                                                    </label>
                                                    <select name="currency_code" id="currency_code" class="form-select ot-input flag_icon_list @error('currency_code') is-invalid @enderror">
                                                        @foreach ($data['currencies'] as $currency)
                                                            <option value="{{ $currency->code }}" {{ Setting('currency_code') == $currency->code ? 'selected' : '' }}>
                                                                {{ $currency->code }} &mdash; {{ $currency->symbol }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Currency End-->

                                            <!--Address Start -->
                                            <div class="col-12 col-md-6 col-xl-6 col-lg-6 mb-3 ">
                                                <label for="inputname" class="form-label">{{ ___('mainapp_common.address') }} <span class="fillable">*</span></label>
                                                <input type="text" name="address" class="form-control ot-input @error('address') is-invalid @enderror" value="{{ Setting('address') }}" placeholder="{{ ___('settings.enter_you_address') }}">
                                                @error('address')
                                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <!--Address End -->

                                            <!--Phone Start -->
                                            <div class="col-12 col-md-6 col-xl-6 col-lg-6 mb-3 ">
                                                <label for="inputname" class="form-label">{{ ___('mainapp_common.phone') }} <span class="fillable">*</span></label>
                                                <input type="text" name="phone" class="form-control ot-input @error('phone') is-invalid @enderror" value="{{ Setting('phone') }}" placeholder="{{ ___('settings.enter_you_phone') }}">
                                                @error('phone')
                                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <!--Phone End -->

                                            <!--Email Start -->
                                            <div class="col-12 col-md-6 col-xl-6 col-lg-6 mb-3 ">
                                                <label for="inputname" class="form-label">{{ ___('mainapp_common.email') }} <span class="fillable">*</span></label>
                                                <input type="email" name="email" class="form-control ot-input @error('email') is-invalid @enderror" value="{{ Setting('email') }}" placeholder="{{ ___('settings.enter_you_email') }}">
                                                @error('email')
                                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <!--Email End -->

                                            <!--School about Start -->
                                            <div class="col-12">
                                                <label for="inputname" class="form-label">{{ ___('settings.school_about') }} <span class="fillable">*</span></label>
                                                <textarea name="school_about" class="m-0 form-control ot-input @error('school_about') is-invalid @enderror" cols="30" rows="10">{{ Setting('school_about') }}"</textarea>
                                                @error('school_about')
                                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <!--School about End -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <!-- Update Button Start-->
                            <div class="text-end">
                                <button class="btn btn-lg ot-btn-primary"><span><i class="fa-solid fa-save"></i>
                                    </span>{{ ___('mainapp_common.update') }}</button>
                            </div>
                            <!-- Update Button End-->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
