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
                    <h4 class="bradecrumb-title mb-1">{{ $data['title'] }}</h4>
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
                <form action="{{ route('template.store') }}" enctype="multipart/form-data" method="post"
                    id="template-store">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label for="title" class="form-label ">{{ ___('common.title') }} <span
                                            class="fillable">*</span> </label>
                                    <input class="form-control ot-input" name="title"
                                        value="{{ old('title') }}" list="datalistOptions" id="title"
                                        placeholder="{{ ___('common.title') }}">

                                    <div id="validationServer04Feedback" class="invalid-feedback"></div>
                                </div>

                                <div class="col-md-6 mb-3">

                                    <label for="type" class="form-label">{{ ___('common.type') }} <span
                                            class="fillable">*</span></label>
                                    <select
                                        class="type nice-select niceSelect bordered_style wide"
                                        name="type" id="type" aria-describedby="validationServer04Feedback">
                                        <option value="{{ App\Enums\TemplateType::SMS }}"
                                            {{ old('type') == App\Enums\TemplateType::SMS ? 'selected' : '' }}>
                                            {{ ___('common.sms') }}</option>
                                        <option value="{{ App\Enums\TemplateType::MAIL }}"
                                            {{ old('type') == App\Enums\TemplateType::MAIL ? 'selected' : '' }}>
                                            {{ ___('common.mail') }}</option>
                                        </option>
                                    </select>


                                        <div id="validationServer04Feedback" class="invalid-feedback"></div>

                                </div>

                                <div class="col-md-6 mb-3  __sms">

                                    <label for="template_sms" class="form-label">{{ ___('common.template') }} <span
                                            class="fillable">*</span></label>
                                    <select
                                        class="template nice-select niceSelect bordered_style wide"
                                        name="template_sms" id="template_sms" aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('common.select template') }}</option>
                                        @foreach ($data['templates'] as $template)
                                            @if ($template->type == 'sms')
                                                <option value="{{ $template->id }}">{{ $template->title }}</option>
                                            @endif
                                        @endforeach
                                    </select>

                                    <div id="validationServer04Feedback" class="invalid-feedback"></div>

                                </div>

                                <div class="col-md-6 mb-3  __mail">

                                    <label for="template_mail" class="form-label">{{ ___('common.template') }} <span
                                            class="fillable">*</span></label>
                                    <select
                                        class="template nice-select niceSelect bordered_style wide"
                                        name="template_mail" id="template_mail"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('common.select template') }}</option>
                                        @foreach ($data['templates'] as $template)
                                            @if ($template->type == 'mail')
                                                <option value="{{ $template->id }}">{{ $template->title }}</option>
                                            @endif
                                        @endforeach
                                    </select>

                                        <div id="validationServer04Feedback" class="invalid-feedback"></div>

                                </div>



                                {{-- mail --}}
                                <div class="col-md-12 __mail">
                                    <label for="exampleDataList" class="form-label ">{{ ___('common.Attachment') }} <span
                                            class="fillable"></span></label>
                                    <div class="ot_fileUploader left-side mb-3">
                                        <input class="form-control" type="text"
                                            placeholder="{{ ___('common.Attachment') }}" readonly="" id="placeholder">
                                        <button class="primary-btn-small-input" type="button">
                                            <label class="btn btn-lg ot-btn-primary"
                                                for="fileBrouse">{{ ___('common.browse') }}</label>
                                            <input type="file" class="d-none form-control attachment" name="attachment"
                                                id="fileBrouse">
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 __mail">
                                    <label for="mail_description"
                                        class="form-label ">{{ ___('common.mail_description') }}</label>
                                    <textarea
                                        class="form-control mail_description ot-textarea @error('mail_description') is-invalid @enderror"
                                        name="mail_description" list="datalistOptions" id="mail_description"
                                        placeholder="{{ ___('account.enter_description') }}">{{ old('mail_description') }}</textarea>
                                    @error('mail_description')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                {{-- sms --}}
                                <div class="col-md-12 mb-3 __sms">
                                    <label
                                        class="form-label ">{{ ___('common.sms_description') }}</label>
                                    <textarea  class="form-control sms_description ot-textarea @error('sms_description') is-invalid @enderror"
                                        name="sms_description" list="datalistOptions" id="sms_description">{{ old('sms_description') }}</textarea>
                                    @error('sms_description')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">

                                    <label for="user_type" class="form-label">{{ ___('common.user type') }}
                                        <span class="fillable">*</span></label>
                                    <select
                                        class="user_type nice-select niceSelect bordered_style wide"
                                        name="user_type" id="user_type"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="{{ App\Enums\UserType::ROLE }}"
                                            {{ old('user_type') == App\Enums\UserType::ROLE ? 'selected' : '' }}>
                                            {{ ___('common.role') }}</option>
                                        <option value="{{ App\Enums\UserType::INDIVIDUAL }}"
                                            {{ old('user_type') == App\Enums\UserType::INDIVIDUAL ? 'selected' : '' }}>
                                            {{ ___('common.individual') }}</option>
                                        <option value="{{ App\Enums\UserType::CLASSSECTION }}"
                                            {{ old('user_type') == App\Enums\UserType::CLASSSECTION ? 'selected' : '' }}>
                                            {{ ___('common.class') }}</option>
                                    </select>

                                        <div id="validationServer04Feedback" class="invalid-feedback"></div>

                                </div>


                                <div class="col-lg-12 __role">
                                    <label for="validationServer04" class="form-label">{{ ___('common.roles') }}
                                        <span class="fillable">*</span></label>
                                    <select
                                        class="form-control role_ids select2_multy wide nice-select"
                                        name="role_ids" id="role_ids" multiple="multiple">
                                        <option value="">{{ ___('staff.select_role') }}</option>
                                        @foreach ($data['roles'] as $role)
                                            <option {{ old('role') == $role->id ? 'selected' : '' }}
                                                value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    <div id="validationServer04Feedback" class="invalid-feedback"></div>
                                </div>


                                <div class="col-lg-6 col-md-6 mb-3 __individual">
                                    <label for="role" class="form-label">{{ ___('common.role') }} <span
                                            class="fillable">*</span></label>
                                    <select
                                        class="role nice-select niceSelect bordered_style wide"
                                        name="role" id="role"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('staff.select_role') }}</option>
                                        @foreach ($data['roles'] as $role)
                                            <option {{ old('role') == $role->id ? 'selected' : '' }}
                                                value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    <div id="validationServer04Feedback" class="invalid-feedback"></div>

                                </div>

                                <div class="col-lg-6 col-md-6 mb-3 __individual">
                                    <label for="users" class="form-label">{{ ___('common.user') }} <span
                                            class="fillable">*</span></label>
                                    <select
                                        class="form-control users select2_multy wide nice-select"
                                        name="users" id="users" multiple="multiple"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('staff.select_name') }}</option>

                                    </select>
                                        <div id="validationServer04Feedback" class="invalid-feedback"></div>
                                </div>

                                <div class="col-md-6 mb-3 __class">
                                    <label for="getSections" class="form-label">{{ ___('student_info.class') }}
                                        <span class="fillable">*</span></label>
                                    <select id="getSections"
                                        class="nice-select niceSelect bordered_style wide class"
                                        name="class"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('student_info.select_class') }}</option>
                                        @foreach ($data['classes'] as $item)
                                            <option {{ old('class') == $item->id ? 'selected' : '' }}
                                                value="{{ $item->class->id }}">{{ $item->class->name }}
                                        @endforeach
                                        </option>
                                    </select>

                                        <div id="validationServer04Feedback" class="invalid-feedback"></div>
                                </div>

                                <div class="col-md-6 mb-3 __class">

                                    <label for="validationServer04" class="form-label">{{ ___('student_info.section') }}
                                        <span class="fillable">*</span></label>
                                    <select id="section_ids"
                                        class="form-control sections select2_multy wide nice-select bordered_style"
                                        name="section_ids" aria-describedby="validationServer04Feedback"
                                        multiple="multiple">
                                        <option value="" disabled>{{ ___('examination.select_subject') }}</option>
                                    </select>

                                    <div id="validationServer04Feedback" class="invalid-feedback"></div>

                                </div>

                                <div class="col-md-12 mt-24">
                                    <div class="text-end">
                                        <button type="button" class="btn btn-lg ot-btn-primary"
                                            onclick="return smsMailSubmit(event)"><span><i class="fa-solid fa-save"></i>
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
