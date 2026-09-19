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
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ ___('common.home') }}</a></li>
                        <li class="breadcrumb-item" aria-current="page"><a
                                href="{{ route('template.index') }}">{{ ___('common.templates') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $data['title'] }}</li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}
        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('template.store') }}" enctype="multipart/form-data" method="post" id="template-store">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('common.title') }} <span
                                        class="fillable">*</span> </label>
                                    <input class="form-control ot-input @error('title') is-invalid @enderror" name="title"
                                        value="{{ old('title') }}" list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('common.title') }}">
                                    @error('title')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">

                                    <label for="validationServer04" class="form-label">{{ ___('common.type') }} <span class="fillable">*</span></label>
                                    <select class="type nice-select niceSelect bordered_style wide @error('type') is-invalid @enderror"
                                    name="type" id="validationServer04"
                                    aria-describedby="validationServer04Feedback">
                                        <option value="{{ App\Enums\TemplateType::SMS }}" {{old('type') == App\Enums\TemplateType::SMS ? 'selected':''}}>{{ ___('common.sms') }}</option>
                                        <option value="{{ App\Enums\TemplateType::MAIL }}" {{old('type') == App\Enums\TemplateType::MAIL ? 'selected':''}}>{{ ___('common.mail') }}</option>
                                        </option>
                                    </select>

                                    @error('type')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>


                               {{-- mail --}}
                               <div class="col-md-12 __mail">
                                <label for="exampleDataList"
                                    class="form-label ">{{ ___('common.attachment') }} <span
                                        class="fillable"></span></label>
                                <div class="ot_fileUploader left-side mb-3">
                                    <input class="form-control" type="text"
                                        placeholder="{{ ___('common.Attachment') }}" readonly="" id="placeholder">
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="btn btn-lg ot-btn-primary"
                                            for="fileBrouse">{{ ___('common.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="attachment"
                                            id="fileBrouse">
                                    </button>
                                </div>
                                </div>
                                <div class="col-md-12 mb-3 __mail">
                                    <label for="exampleDataList" class="form-label ">{{ ___('common.mail_description') }}</label>
                                    <textarea id=summernote class="form-control ot-textarea @error('mail_description') is-invalid @enderror" name="mail_description"
                                    list="datalistOptions" id="exampleDataList"
                                    placeholder="{{ ___('account.enter_description') }}">{{ old('mail_description') }}</textarea>
                                    @error('mail_description')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                {{-- sms --}}
                                <div class="col-md-12 mb-3 __sms">
                                    <label for="exampleDataList" class="form-label ">{{ ___('common.sms_description') }}</label>
                                    <textarea class="form-control ot-textarea @error('sms_description') is-invalid @enderror" name="sms_description"
                                    list="datalistOptions" id="exampleDataList"
                                    placeholder="{{ ___('account.enter_description') }}">{{ old('sms_description') }}</textarea>
                                    @error('sms_description')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mt-24">
                                    <div class="text-end">
                                        <button class="btn btn-lg ot-btn-primary"><span><i class="fa-solid fa-save"></i>
                                            </span>{{ ___('common.submit') }}</button>
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
    <script src="{{ global_asset('backend') }}/assets/js/__sms_mail.js"></script>
@endpush
