@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')
    <div class="page-content">

        {{-- bradecrumb Area S t a r t --}}
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="bradecrumb-title mb-1">{{ $data['title'] }}</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> {{ ___('common.home') }} </a></li>
                        <li class="breadcrumb-item"><a href="{{ route('page.index') }}">{{ $data['title'] }}</a></li>
                        <li class="breadcrumb-item">{{ ___('common.edit') }}</li>

                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('settings.general-settings.translate.update') }}" enctype="multipart/form-data" method="post"
                    id="visitForm">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-lg-12">

                            @foreach ($data['languages'] as $language)

                                <div class="row mb-3">
                                    <div class="col-md-12 mb-3">
                                        <label for="exampleDataList" class="form-label ">{{ ___('settings.application_name') }} - ({{$language->name}})<span
                                                class="fillable">*</span></label>
                                        <input class="form-control ot-input @error('value') is-invalid @enderror" name="{{$data['translates'][$language->code][0]->name}}[{{$language->code}}]"
                                            value="{{isset($data['translates'][$language->code][0]) ? $data['translates'][$language->code][0]->value :  @$data['page']->value}}" list="datalistOptions" id="exampleDataList"
                                            placeholder="{{ ___('common.enter_name') }}">
                                        @error('value')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="exampleDataList" class="form-label ">{{ ___('settings.footer_text') }} - ({{$language->name}})<span
                                                class="fillable">*</span></label>
                                        <input class="form-control ot-input @error('value') is-invalid @enderror" name="{{$data['translates'][$language->code][1]->name}}[{{$language->code}}]"
                                            value="{{isset($data['translates'][$language->code][1]) ? $data['translates'][$language->code][1]->value :  @$data['page']->value}}" list="datalistOptions" id="exampleDataList"
                                            placeholder="{{ ___('common.enter_name') }}">
                                        @error('value')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.address') }} - ({{$language->name}})<span
                                                class="fillable">*</span></label>
                                        <input class="form-control ot-input @error('value') is-invalid @enderror" name="{{$data['translates'][$language->code][2]->name}}[{{$language->code}}]"
                                            value="{{isset($data['translates'][$language->code][2]) ? $data['translates'][$language->code][2]->value :  @$data['page']->value}}" list="datalistOptions" id="exampleDataList"
                                            placeholder="{{ ___('common.enter_name') }}">
                                        @error('value')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.phone') }} - ({{$language->name}})<span
                                                class="fillable">*</span></label>
                                        <input class="form-control ot-input @error('value') is-invalid @enderror" name="{{$data['translates'][$language->code][3]->name}}[{{$language->code}}]"
                                            value="{{isset($data['translates'][$language->code][3]) ? $data['translates'][$language->code][3]->value :  @$data['page']->value}}" list="datalistOptions" id="exampleDataList"
                                            placeholder="{{ ___('common.enter_name') }}">
                                        @error('value')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label for="exampleDataList" class="form-label">{{ ___('settings.school_about') }} - ({{$language->name}})</label>
                                        <textarea class="form-control summernote ot-textarea @error('value') is-invalid @enderror" name="{{$data['translates'][$language->code][4]->name}}[{{$language->code}}]"
                                        list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('common.Enter description') }}">{{isset($data['translates'][$language->code][4]) ? $data['translates'][$language->code][4]->value :  @$data['page']->value}}</textarea>
                                        @error('content')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach


                                <div class="col-md-12 mt-24">
                                    <div class="text-end">
                                        <button class="btn btn-lg ot-btn-primary"><span><i class="fa-solid fa-save"></i>
                                            </span>{{ ___('common.update') }}</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function () {
            try {
                $('.summernote').summernote({
                    tabsize: 2,
                    height: 300
                });
            } catch (e) {

            }
        });
    </script>
@endpush
