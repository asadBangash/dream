@extends('frontend.master')
@section('title')
    {{ ___('frontend.online_admission') }}
@endsection

@push('css')
    <style>
        .ot_fileUploader {
            display: flex;
            align-items: center;
            border: 1px solid var(--ot-border-primary) !important;
            height: 48px;
        }

        .left-side {
            flex-direction: row-reverse;

        }

        .ot_fileUploader input.form-control {
            border: 0 !important;
            border-radius: 3px;
            border: 0;
            height: 40px;
            width: 100%;
            box-shadow: none !important;
        }

        .ot_fileUploader .ot-btn-primary {
            padding: 10px 20px;
        }

        .ot-btn-common,
        .ot-dropdown-btn,
        .ot-btn-primary,
        .ot-btn-success,
        .ot-btn-danger,
        .ot-btn-warning,
        .ot-btn-info {
            background: linear-gradient(130.57deg, #392C7D -0.48%, #314CAD 71.79%) !important;
        }

        .ot-btn-common,
        .ot-dropdown-btn,
        .ot-btn-primary,
        .ot-btn-success,
        .ot-btn-danger,
        .ot-btn-warning,
        .ot-btn-info {
            color: #ffffff !important;
            font-weight: 500;
            font-size: 13px;
            text-transform: capitalize;
        }

        .ot_fileUploader button {
            background: transparent;
        }

        button {
            border: none;
            outline: none;
        }

        input[type="file"] {
            padding-left: 10px !important;
        }
    </style>
@endpush

@section('main')


    <!-- bradcam::start  -->
    <div class="breadcrumb_area" data-background="{{ @globalAsset(@$sections['study_at']->upload->path, '1920X700.webp') }}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-xl-5">
                    <div class="breadcam_wrap text-center">
                        <h3>{{ ___('frontend.online_admission') }}</h3>
                        <div class="custom_breadcam">
                            <a href="{{ url('/') }}" class="breadcrumb-item">{{ ___('frontend.home') }}</a>
                            <a href="#" class="breadcrumb-item">{{ ___('frontend.online_admission') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- bradcam::end  -->

    <!-- ADMISSION::START  -->
    <div class="search_result_area section_padding">
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-xl-10">
                    <div class="search_result_box mb_30">
                        @if (session('message'))
                            <div class="section__title mb_50">
                                <h5 class="mb-0 text-success text-center">{{ session('message') }} </h5>
                            </div>
                        @else
                            <div class="section__title mb_50">
                                <h5 class="mb-0 text-warning text-center">
                                    {{ ___('frontend.please_fill_out_the_form_for_admission_guidance_and_information') }}.
                                </h5>
                            </div>
                        @endif


                        <form class="form-area contact-form" action="{{ route('frontend.online-admission') }}"
                            id="admission" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                @if (is_show('student_first_name'))
                                    <div class="col-xl-6">
                                        <label class="primary_label2">{{ ___('frontend.first_name') }} @if (is_required('student_first_name'))
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        <input name="first_name" placeholder="{{ ___('frontend.enter_first_name') }}"
                                            class="first_name form-control ot-input mb_30"
                                            @if (is_required('student_first_name')) required @endif type="text">
                                    </div>
                                @endif

                                @if (is_show('student_last_name'))
                                    <div class="col-xl-6">
                                        <label class="primary_label2">{{ ___('frontend.last_name') }} @if (is_required('student_last_name'))
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        <input name="last_name" placeholder="{{ ___('frontend.enter_last_name') }}"
                                            class="last_name form-control ot-input mb_30"
                                            @if (is_required('student_last_name')) required @endif type="text">
                                    </div>
                                @endif

                                @if (is_show('student_phone'))
                                    <div class="col-xl-6">
                                        <label class="primary_label2">{{ ___('frontend.phone_no') }} @if (is_required('student_phone'))
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        <input name="phone" placeholder="{{ ___('frontend.phone_no') }}"
                                            class="phone form-control ot-input mb_30"
                                            @if (is_required('student_phone')) required @endif type="text">
                                    </div>
                                @endif

                                @if (is_show('cpr_no'))
                                    <div class="col-xl-6">
                                        <label class="primary_label2">{{ ___('frontend.CPR_Number') }} @if (is_required('cpr_no'))
                                                <span class="text-danger">*</span>
                                            @endif </label>
                                        <input name="cpr_no" placeholder="{{ ___('frontend.CPR_Number') }}"
                                            class="email form-control ot-input mb_30" type="text"
                                            @if (is_required('cpr_no')) required @endif>
                                    </div>
                                @endif

                                @if (is_show('student_email'))
                                    <div class="col-xl-6">
                                        <label class="primary_label2">{{ ___('frontend.email_address') }} @if (is_required('student_email'))
                                                <span class="text-danger">*</span>
                                            @endif </label>
                                        <input name="email" placeholder="{{ ___('frontend.type_email_address') }}"
                                            pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$"
                                            class="email form-control ot-input mb_30" type="email"
                                            @if (is_required('student_email')) required @endif>
                                    </div>
                                @endif

                                @if (is_show('student_dob'))
                                    <div class="col-xl-6">
                                        <label class="primary_label2">{{ ___('frontend.date_of_birth') }} @if (is_required('student_dob'))
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        <input name="dob" placeholder="{{ ___('frontend.enter_date_of_birth') }}"
                                            class="dob form-control ot-input mb_30"
                                            @if (is_required('student_dob')) required @endif type="date">
                                    </div>
                                @endif

                                @if (is_show('student_photo'))
                                    <div class="col-xl-6 mb_24">
                                        <label for="exampleDataList"
                                            class="primary_label2">{{ ___('common.Student_Image') }}
                                            {{ ___('common.(100 x 100 px)') }}<span class="fillable"></span>
                                            @if (is_required('student_photo'))
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>


                                        <div class="ot_fileUploader left-side mb-3">
                                            <input class="form-control" type="text"
                                                placeholder="{{ ___('common.image') }}" readonly="" id="placeholder">
                                            <button class="primary-btn-small-input" type="button">
                                                <label class="btn btn-lg ot-btn-primary"
                                                    for="fileBrouse">{{ ___('common.browse') }}</label>
                                                <input type="file" class="d-none form-control" name="student_image"
                                                    id="fileBrouse" accept="image/*">
                                            </button>
                                        </div>
                                    </div>
                                @endif

                                @if (is_show('session'))
                                    <div class="col-xl-6 mb_24">
                                        <label class="primary_label2"
                                            for="#">{{ ___('frontend.academic_year_session') }} @if (is_required('session'))
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        <select class="theme_select wide session" name="session"
                                            @if (is_required('session')) required @endif>
                                            <option value="" data-display="{{ ___('frontend.Select') }}">
                                                {{ ___('frontend.select_year_session') }}</option>
                                            @foreach ($data['sessions'] as $item)
                                                <option {{ old('session') == $item->id ? 'selected' : '' }}
                                                    value="{{ $item->id }}">{{ @$item->defaultTranslate->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('session'))
                                            <small class="text-danger">{{ $errors->first('session') }}</small>
                                        @endif
                                    </div>
                                @endif

                                @if (is_show('class'))
                                    <div class="col-xl-6 mb_24">
                                        <label class="primary_label2" for="#">{{ ___('frontend.Class') }}
                                            @if (is_required('class'))
                                                <span class="text-danger">*</span>
                                            @endif </label>
                                        <select class="theme_select wide classes" name="class"
                                            @if (is_required('class')) required @endif>
                                            <option value="" data-display="{{ ___('frontend.Select') }}">
                                                {{ ___('frontend.select_class') }}</option>
                                        </select>
                                        @if ($errors->has('class'))
                                            <small class="text-danger">{{ $errors->first('class') }}</small>
                                        @endif
                                    </div>
                                @endif


                                @if (is_show('section'))
                                    <div class="col-xl-6 mb_24">
                                        <label class="primary_label2" for="#">{{ ___('frontend.Section') }}
                                            @if (is_required('section'))
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        <select class="theme_select wide sections" name="section"
                                            @if (is_required('section')) required @endif>
                                            <option value="" data-display="{{ ___('frontend.Select') }}">
                                                {{ ___('frontend.select_section') }}</option>
                                        </select>
                                        @if ($errors->has('section'))
                                            <small class="text-danger">{{ $errors->first('section') }}</small>
                                        @endif
                                    </div>
                                @endif

                                @if (is_show('shift'))
                                    <div class="col-xl-6 mb_24">
                                        <label class="primary_label2" for="#">{{ ___('frontend.Shift') }}
                                            @if (is_required('shift'))
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        <select class="theme_select wide" name="shift"
                                            @if (is_required('session')) required @endif>
                                            <option value="" data-display="{{ ___('frontend.Select') }}">
                                                {{ ___('frontend.Select_Shift') }}</option>
                                            @foreach ($data['shifts'] as $item)
                                                <option {{ old('shift') == $item->id ? 'selected' : '' }}
                                                    value="{{ $item->id }}">{{ $item->defaultTranslate->name }}
                                                </option>
                                            @endforeach

                                        </select>
                                        @if ($errors->has('shift'))
                                            <small class="text-danger">{{ $errors->first('shift') }}</small>
                                        @endif
                                    </div>
                                @endif


                                @if (is_show('gender'))
                                    <div class="col-xl-6 mb_24">
                                        <label class="primary_label2" for="#">{{ ___('frontend.Gender') }}
                                            @if (is_required('gender'))
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        <select class="theme_select wide gender" name="gender"
                                            @if (is_required('gender')) required @endif>
                                            <option value="" data-display="{{ ___('frontend.Select') }}">
                                                {{ ___('frontend.select_gender') }}</option>
                                            @foreach ($data['genders'] as $item)
                                                <option {{ old('gender') == $item->id ? 'selected' : '' }}
                                                    value="{{ $item->id }}">{{ @$item->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('gender'))
                                            <small class="text-danger">{{ $errors->first('gender') }}</small>
                                        @endif
                                    </div>
                                @endif

                                @if (is_show('religion'))
                                    <div class="col-xl-6 mb_24">
                                        <label class="primary_label2" for="#">{{ ___('frontend.Religion') }}
                                            @if (is_required('religion'))
                                                <span class="text-danger">*</span>
                                            @endif </label>
                                        <select class="theme_select wide religion" name="religion"
                                            @if (is_required('religion')) required @endif>
                                            <option value="" data-display="{{ ___('frontend.Select') }}">
                                                {{ ___('frontend.select_religion') }}</option>
                                            @foreach ($data['religions'] as $item)
                                                <option {{ old('religion') == $item->id ? 'selected' : '' }}
                                                    value="{{ $item->id }}">
                                                    {{ isset($item->defaultTranslate->name) ? $item->defaultTranslate->name : $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('religion'))
                                            <small class="text-danger">{{ $errors->first('religion') }}</small>
                                        @endif
                                    </div>
                                @endif

                                @if (is_show('previous_school'))
                                    <div class="col-xl-6 mb_24">
                                        <label class="primary_label2"
                                            for="#">{{ ___('frontend.attend_school_previously') }} @if (is_required('previous_school_doc'))
                                                <span class="text-danger">*</span>
                                            @endif </label>
                                        <div class="input-check-radio academic-section ">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="previous_school"
                                                    value="1" id="previous_school">
                                                <label class="form-check-label ps-2 pe-5"
                                                    for="previous_school">{{ ___('common.Yes') }}</label>
                                            </div>
                                        </div>

                                        @if ($errors->has('previous_school'))
                                            <small class="text-danger">{{ $errors->first('previous_school') }}</small>
                                        @endif
                                    </div>
                                @endif

                                @if (is_show('previous_school_info'))
                                    <div class="col-xl-6 mb_24 d-none" id="previous_school_info">
                                        <label class="primary_label2"
                                            for="#">{{ ___('frontend.previous_school_information') }} @if (is_required('previous_school_doc'))
                                                <span class="text-danger">*</span>
                                            @endif </label>
                                        <textarea class="form-control" rows="2" name="previous_school_info"></textarea>
                                        @if ($errors->has('previous_school_info'))
                                            <small
                                                class="text-danger">{{ $errors->first('previous_school_info') }}</small>
                                        @endif
                                    </div>
                                @endif

                                @if (is_show('previous_school_doc'))
                                    <div class="col-xl-6 mb_24 d-none" id="previous_school_doc">
                                        <label for="exampleDataList"
                                            class="primary_label2">{{ ___('frontend.previous_school_documents') }}<span
                                                class="fillable"></span>
                                            @if (is_required('previous_school_doc'))
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>

                                        <div class="ot_fileUploader left-side mb-3">
                                            <input class="form-control" type="text"
                                                placeholder="{{ ___('common.image') }}" readonly=""
                                                id="placeholder1">
                                            <button class="primary-btn-small-input" type="button">
                                                <label class="btn btn-lg ot-btn-primary"
                                                    for="fileBrouse1">{{ ___('common.browse') }}</label>
                                                <input type="file" class="d-none form-control"
                                                    name="previous_school_image" id="fileBrouse1" accept="image/*">
                                            </button>
                                        </div>

                                        @if ($errors->has('previous_school_info'))
                                            <small
                                                class="text-danger">{{ $errors->first('previous_school_info') }}</small>
                                        @endif
                                    </div>
                                @endif

                                @if (is_show('place_of_birth'))
                                    <div class="col-xl-6">
                                        <label class="primary_label2">{{ ___('frontend.Place_Of_Birth') }} @if (is_required('place_of_birth'))
                                                <span class="text-danger">*</span>
                                            @endif </label>
                                        <input name="place_of_birth" placeholder="{{ ___('frontend.Place_Of_Birth') }}"
                                            class="email form-control ot-input mb_30" type="text"
                                            @if (is_required('place_of_birth')) required @endif>
                                    </div>
                                @endif

                                @if (is_show('nationality'))
                                    <div class="col-xl-6">
                                        <label class="primary_label2">{{ ___('frontend.Student_Nationality') }}
                                            @if (is_required('student_email'))
                                                <span class="text-danger">*</span>
                                            @endif </label>
                                        <input name="nationality" placeholder="{{ ___('frontend.Student_Nationality') }}"

                                            class="email form-control ot-input mb_30" type="text"
                                            @if (is_required('student_email')) required @endif>
                                    </div>
                                @endif



                                @if (is_show('spoken_lang_at_home'))
                                    <div class="col-xl-6">
                                        <label
                                            class="primary_label2">{{ ___('frontend.Student_Sponken_Language_At_Home') }}
                                            @if (is_required('spoken_lang_at_home'))
                                                <span class="text-danger">*</span>
                                            @endif </label>
                                        <input name="spoken_lang_at_home"
                                            placeholder="{{ ___('frontend.Student_Sponken_Language_At_Home') }}"
                                            class="email form-control ot-input mb_30" type="text"
                                            @if (is_required('spoken_lang_at_home')) required @endif>
                                    </div>
                                @endif

                                @if (is_show('residance_address'))
                                    <div class="col-xl-6">
                                        <label class="primary_label2">{{ ___('frontend.Residance_Address') }} @if (is_required('residance_address'))
                                                <span class="text-danger">*</span>
                                            @endif </label>
                                        <input name="residance_address"
                                            placeholder="{{ ___('frontend.Residance_Address') }}"
                                            class="email form-control ot-input mb_30" type="text"
                                            @if (is_required('residance_address')) required @endif>
                                    </div>
                                @endif

                                @if (is_show('student_document'))
                                    <div class="col-xl-6">
                                        <input type="hidden" name="document_rows[]" value="1">
                                        <label class="primary_label2">{{ ___('frontend.document_name') }} @if (is_required('student_document'))
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        <input name="document_names[1]"
                                            placeholder="{{ ___('frontend.Enter_Document_Name') }}"
                                            class="form-control ot-input mb_30"
                                            @if (is_required('student_document')) required @endif type="text">
                                    </div>
                                    <div class="col-xl-6">
                                        <label for="exampleDataList"
                                            class="primary_label2">{{ ___('frontend.Document') }} <span
                                                class="fillable"></span>
                                            @if (is_required('student_document'))
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>


                                        <div class="ot_fileUploader left-side mb-3">
                                            <input class="form-control" type="text"
                                                placeholder="{{ ___('common.image') }}" readonly=""
                                                id="placeholder5">
                                            <button class="primary-btn-small-input" type="button">
                                                <label class="btn btn-lg ot-btn-primary"
                                                    for="fileBrouse5">{{ ___('common.browse') }}</label>
                                                <input type="file" class="d-none form-control"
                                                    name="document_files[1]" id="fileBrouse5">
                                            </button>
                                        </div>
                                    </div>
                                @endif





                                {{-- <div class="row"> --}}
                                @if (is_show('gurdian_name'))
                                    <div class="col-xl-6">
                                        <label class="primary_label2">{{ ___('frontend.guardian_name') }} @if (is_required('gurdian_name'))
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        <input name="guardian_name"
                                            placeholder="{{ ___('frontend.enter_guardian_name') }}"
                                            class="guardian_name form-control ot-input mb_30"
                                            @if (is_required('gurdian_name')) required @endif type="text">
                                    </div>
                                @endif
                                @if (is_show('gurdian_phone'))
                                    <div class="col-xl-6">
                                        <label class="primary_label2">{{ ___('frontend.guardian_phone') }} @if (is_required('gurdian_phone'))
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        <input name="guardian_phone"
                                            placeholder="{{ ___('frontend.enter_guardian_phone') }}"
                                            class="guardian_phone form-control ot-input mb_30"
                                            @if (is_required('gurdian_phone')) required @endif type="text">
                                    </div>
                                @endif
                                @if (is_show('gurdian_photo'))
                                    <div class="col-xl-6 mb_24">
                                        <label for="exampleDataList"
                                            class="primary_label2">{{ ___('common.Guardian_Image') }}
                                            {{ ___('common.(100 x 100 px)') }}<span class="fillable"></span>
                                            @if (is_required('gurdian_photo'))
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>


                                        <div class="ot_fileUploader left-side mb-3">
                                            <input class="form-control" type="text"
                                                placeholder="{{ ___('common.image') }}" readonly=""
                                                id="placeholder2">
                                            <button class="primary-btn-small-input" type="button">
                                                <label class="btn btn-lg ot-btn-primary"
                                                    for="fileBrouse2">{{ ___('common.browse') }}</label>
                                                <input type="file" class="d-none form-control" name="gurdian_image"
                                                    id="fileBrouse2" accept="image/*">
                                            </button>
                                        </div>
                                    </div>
                                @endif
                                @if (is_show('gurdian_profession'))
                                    <div class="col-xl-6">
                                        <label class="primary_label2">{{ ___('frontend.Guardian_Profession') }}
                                            @if (is_required('gurdian_profession'))
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        <input name="guardian_profession"
                                            placeholder="{{ ___('frontend.Guardian_Profession') }}"
                                            class="guardian_name form-control ot-input mb_30"
                                            @if (is_required('gurdian_profession')) required @endif type="text">
                                    </div>
                                @endif
                                {{-- </div> --}}

                                {{-- <div class="row"> --}}
                                @if (is_show('father_name'))
                                    <div class="col-xl-6">
                                        <label class="primary_label2">{{ ___('frontend.father_name') }} @if (is_required('father_name'))
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        <input name="father_name" placeholder="{{ ___('frontend.father_name') }}"
                                            class="guardian_name form-control ot-input mb_30"
                                            @if (is_required('father_name')) required @endif type="text">
                                    </div>
                                @endif
                                @if (is_show('father_phone'))
                                    <div class="col-xl-6">
                                        <label class="primary_label2">{{ ___('frontend.father_phone') }} @if (is_required('father_phone'))
                                                <span class="text-danger">*</span>
                                            @endif </label>
                                        <input name="father_phone" placeholder="{{ ___('frontend.father_phone') }}"
                                            class="guardian_phone form-control ot-input mb_30"
                                            @if (is_required('father_phone')) required @endif type="text">
                                    </div>
                                @endif

                                @if (is_show('father_nationality'))
                                    <div class="col-xl-6">
                                        <label class="primary_label2">{{ ___('frontend.Father_Nationality') }}
                                            @if (is_required('father_nationality'))
                                                <span class="text-danger">*</span>
                                            @endif </label>
                                        <input name="father_nationality"
                                            placeholder="{{ ___('frontend.Father_Nationality') }}"
                                            class="email form-control ot-input mb_30" type="text"
                                            @if (is_required('father_nationality')) required @endif>
                                    </div>
                                @endif
                                @if (is_show('father_photo'))
                                    <div class="col-xl-6 mb_24">
                                        <label for="exampleDataList"
                                            class="primary_label2">{{ ___('frontend.Father_Image') }}
                                            {{ ___('common.(100 x 100 px)') }}<span class="fillable"></span>
                                            @if (is_required('father_photo'))
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>


                                        <div class="ot_fileUploader left-side mb-3">
                                            <input class="form-control" type="text"
                                                placeholder="{{ ___('common.image') }}" readonly=""
                                                id="placeholder3">
                                            <button class="primary-btn-small-input" type="button">
                                                <label class="btn btn-lg ot-btn-primary"
                                                    for="fileBrouse3">{{ ___('common.browse') }}</label>
                                                <input type="file" class="d-none form-control" name="father_image"
                                                    id="fileBrouse3" accept="image/*">
                                            </button>
                                        </div>
                                    </div>
                                @endif
                                @if (is_show('father_profession'))
                                    <div class="col-xl-6">
                                        <label class="primary_label2">{{ ___('frontend.father_profession') }} @if (is_required('father_profession'))
                                                <span class="text-danger">*</span>
                                            @endif </label>
                                        <input name="father_profession"
                                            placeholder="{{ ___('frontend.father_profession') }}"
                                            class="guardian_name form-control ot-input mb_30"
                                            @if (is_required('father_profession')) required @endif type="text">
                                    </div>
                                @endif
                                {{-- </div> --}}

                                {{-- <div class="row"> --}}
                                @if (is_show('mother_name'))
                                    <div class="col-xl-6">
                                        <label class="primary_label2">{{ ___('frontend.mother_name') }} @if (is_required('mother_name'))
                                                <span class="text-danger">*</span>
                                            @endif </label>
                                        <input name="mother_name" placeholder="{{ ___('frontend.mother_name') }}"
                                            class="guardian_name form-control ot-input mb_30"
                                            @if (is_required('mother_name')) required @endif type="text">
                                    </div>
                                @endif
                                @if (is_show('mother_phone'))
                                    <div class="col-xl-6">
                                        <label class="primary_label2">{{ ___('frontend.mother_phone') }} @if (is_required('mother_phone'))
                                                <span class="text-danger">*</span>
                                            @endif </label>
                                        <input name="mother_phone"
                                            placeholder="{{ ___('frontend.enter_guardian_phone') }}"
                                            class="guardian_phone form-control ot-input mb_30"
                                            @if (is_required('mother_phone')) required @endif type="text">
                                    </div>
                                @endif
                                @if (is_show('mother_photo'))
                                    <div class="col-xl-6 mb_24">
                                        <label for="exampleDataList"
                                            class="primary_label2">{{ ___('common.Guardian_Image') }}
                                            {{ ___('common.(100 x 100 px)') }}<span class="fillable"></span>
                                            @if (is_required('mother_photo'))
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>


                                        <div class="ot_fileUploader left-side mb-3">
                                            <input class="form-control" type="text"
                                                placeholder="{{ ___('common.image') }}" readonly=""
                                                id="placeholder4">
                                            <button class="primary-btn-small-input" type="button">
                                                <label class="btn btn-lg ot-btn-primary"
                                                    for="fileBrouse4">{{ ___('common.browse') }}</label>
                                                <input type="file" class="d-none form-control" name="mother_image"
                                                    id="fileBrouse4" accept="image/*">
                                            </button>
                                        </div>
                                    </div>
                                @endif

                                @if (is_show('mother_profession'))
                                    <div class="col-xl-6">
                                        <label class="primary_label2">{{ ___('frontend.mother_profession') }}
                                            @if (is_required('mother_profession'))
                                                <span class="text-danger">*</span>
                                            @endif </label>
                                        <input name="mother_profession"
                                            placeholder="{{ ___('frontend.mother_profession') }}"
                                            class="guardian_name form-control ot-input mb_30"
                                            @if (is_required('mother_profession')) required @endif type="text">
                                    </div>
                                @endif
                                {{-- </div> --}}

                                <div class="col-xl-12 text-left d-flex">
                                    <button type="submit"
                                        class="theme_btn2  submit-btn text-center d-flex align-items-center m-0 w-100 justify-content-center text-uppercase large_btn">{{ ___('frontend.Submit') }}</button>
                                    {{-- mail-script.js --}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- ADMISSION::END  -->


@endsection

@push('script')
    <script>
        // ONLICK BROUSE FILE UPLOADER
        var fileInp = document.getElementById("fileBrouse");
        var fileInp1 = document.getElementById("fileBrouse1");
        var fileInp2 = document.getElementById("fileBrouse2");
        var fileInp3 = document.getElementById("fileBrouse3");
        var fileInp4 = document.getElementById("fileBrouse4");
        var fileInp5 = document.getElementById("fileBrouse5");


        if (fileInp) {
            fileInp.addEventListener("change", showFileName);

            function showFileName(event) {
                var fileInp = event.srcElement;
                var fileName = fileInp.files[0].name;
                document.getElementById("placeholder").placeholder = fileName;
            }
        }

        if (fileInp2) {
            fileInp2.addEventListener("change", showFileName);

            function showFileName(event) {
                var fileInp = event.srcElement;
                var fileName = fileInp.files[0].name;
                document.getElementById("placeholder2").placeholder = fileName;
            }
        }
        if (fileInp3) {
            fileInp3.addEventListener("change", showFileName);

            function showFileName(event) {
                var fileInp = event.srcElement;
                var fileName = fileInp.files[0].name;
                document.getElementById("placeholder3").placeholder = fileName;
            }
        }
        if (fileInp4) {
            fileInp4.addEventListener("change", showFileName);

            function showFileName(event) {
                var fileInp = event.srcElement;
                var fileName = fileInp.files[0].name;
                document.getElementById("placeholder4").placeholder = fileName;
            }
        }

        if (fileInp5) {
            fileInp5.addEventListener("change", showFileName);

            function showFileName(event) {
                var fileInp = event.srcElement;
                var fileName = fileInp.files[0].name;
                document.getElementById("placeholder5").placeholder = fileName;
            }
        }

        if (fileInp1) {
            fileInp1.addEventListener("change", showFileName);

            function showFileName(event) {
                var fileInp = event.srcElement;
                var fileName = fileInp.files[0].name;
                document.getElementById("placeholder1").placeholder = fileName;
            }
        }

        $(document).ready(function() {
            function checkCheckboxState() {
                var isChecked = $('#previous_school').prop('checked');
                console.log(isChecked)
                if (isChecked) {
                    $('#previous_school_info').removeClass('d-none');
                    $('#previous_school_doc').removeClass('d-none');
                } else {
                    $('#previous_school_info').addClass('d-none');
                    $('#previous_school_doc').addClass('d-none');
                }
            }

            $('#previous_school').change(checkCheckboxState);
            checkCheckboxState();
        });
    </script>
@endpush
