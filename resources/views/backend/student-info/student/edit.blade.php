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
                                    href="{{ route('student.index') }}">{{ ___('student_info.student_list') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ ___('common.add_new') }}</li>
                        </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}


        <div class="card ot-card">
            <div class="card-body">
                {{-- @dd($data) --}}
                <form action="{{ route('student.update') }}" enctype="multipart/form-data" method="post" id="visitForm">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="user_id" value="{{ @$data['student']->user_id }}">
                    <input type="hidden" name="id" value="{{ @$data['student']->id }}">

                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('student_info.admission_no') }}
                                        <span class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('admission_no') is-invalid @enderror"
                                        type="number" name="admission_no" list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('student_info.enter_admission_no') }}"
                                        value="{{ old('admission_no', @$data['student']->admission_no) }}">
                                    @error('admission_no')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('student_info.roll_no') }}
                                        <span class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('roll_no') is-invalid @enderror"
                                        name="roll_no" list="datalistOptions" id="exampleDataList" type="number"
                                        placeholder="{{ ___('student_info.enter_roll_no') }}"
                                        value="{{ old('roll_no', @$data['session_class_student']->roll) }}">
                                    @error('roll_no')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('student_info.first_name') }}
                                        <span class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('first_first_name') is-invalid @enderror"
                                        name="first_name" list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('student_info.enter_first_name') }}"
                                        value="{{ old('first_name', @$data['student']->first_name) }}">
                                    @error('first_name')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('student_info.last_name') }}
                                        <span class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('last_name') is-invalid @enderror"
                                        name="last_name" list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('student_info.enter_last_name') }}"
                                        value="{{ old('last_name', @$data['student']->last_name) }}">
                                    @error('last_name')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">{{ ___('frontend.Arabic_Name') }} </label>
                                    <input name="student_ar_name" placeholder="{{ ___('frontend.Arabic_Name') }}"
                                        class="email form-control ot-input mb_30" type="text"
                                        value="{{ old('student_ar_name', @$data['student']->student_ar_name) }}">
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('student_info.mobile') }} <span
                                            class="fillable"></span></label>
                                    <input class="form-control ot-input @error('mobile') is-invalid @enderror"
                                        name="mobile" list="datalistOptions" id="exampleDataList" type="number"
                                        placeholder="{{ ___('student_info.enter_mobile') }}"
                                        value="{{ old('mobile', @$data['student']->mobile) }}">
                                    @error('mobile')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('common.email') }} <span
                                            class="fillable"></span></label>
                                    <input class="form-control ot-input @error('email') is-invalid @enderror"
                                        name="email" list="datalistOptions" id="exampleDataList" type="email"
                                        placeholder="{{ ___('student_info.enter_email') }}"
                                        value="{{ old('email', @$data['student']->email) }}">
                                    @error('email')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">{{ ___('frontend.Username') }} </label>
                                    <input name="username" placeholder="{{ ___('frontend.Username') }}"
                                        class="username form-control ot-input mb_30" type="text"
                                        value="{{ old('username', @$data['student']->user->username) }}">
                                    @if ($errors->has('username'))
                                        <div class="error text-danger">{{ $errors->first('username') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="departmentId" class="form-label">{{ ___('common.Department') }}
                                        <span class="fillable">*</span></label>
                                    <select
                                        class="nice-select niceSelect bordered_style wide @error('department_id') is-invalid @enderror"
                                        name="department_id" id="departmentId">
                                        <option value="">{{ ___('student_info.select Department') }}</option>
                                        @foreach ($data['departments'] ?? [] as $id => $name)
                                            <option {{ @$data['student']->department_id == $id ? 'selected' : '' }}
                                                value="{{ $id }}">{{ $name }}
                                            </option>
                                        @endforeach
                                        </option>
                                    </select>

                                    @error('department_id')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3">

                                    <label for="validationServer04" class="form-label">{{ ___('student_info.class') }}
                                        <span class="fillable">*</span></label>
                                    <select id="getSections"
                                        class="nice-select niceSelect bordered_style wide @error('class') is-invalid @enderror"
                                        name="class" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('student_info.select_class') }}</option>
                                        @foreach ($data['classes'] as $item)
                                            <option
                                                {{ @$data['session_class_student']->classes_id == $item->class->id ? 'selected' : '' }}
                                                value="{{ $item->class->id }}">{{ $item->class->name }}
                                        @endforeach
                                        </option>
                                    </select>
                                    @error('class')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="validationServer04" class="form-label">{{ ___('student_info.section') }}
                                        <span class="fillable">*</span></label>
                                    <select id="getSections"
                                        class="nice-select sections niceSelect bordered_style wide @error('section') is-invalid @enderror"
                                        name="section" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('student_info.select_section') }}</option>
                                        @foreach ($data['sections'] as $item)
                                            <option
                                                {{ @$data['session_class_student']->section_id == $item->section->id ? 'selected' : '' }}
                                                value="{{ $item->section->id }}">{{ $item->section->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('section')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3">

                                    <label for="validationServer04" class="form-label">{{ ___('student_info.shift') }}
                                        <span class="fillable"></span></label>
                                    <select
                                        class="nice-select niceSelect bordered_style wide @error('shift') is-invalid @enderror"
                                        name="shift" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('student_info.select_shift') }}</option>
                                        @foreach ($data['shifts'] as $item)
                                            <option
                                                {{ @$data['student']->session_class_student->shift->id == $item->id ? 'selected' : '' }}
                                                value="{{ $item->id }}">{{ $item->name }}
                                        @endforeach
                                    </select>

                                    @error('shift')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('common.date_of_birth') }}
                                        <span class="fillable">*</span></label>
                                    <input type="date"
                                        class="form-control ot-input @error('date_of_birth') is-invalid @enderror"
                                        name="date_of_birth" list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('common.date_of_birth') }}"
                                        value="{{ old('date_of_birth', @$data['student']->dob) }}">
                                    @error('date_of_birth')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3">

                                    <label for="validationServer04" class="form-label">{{ ___('student_info.religion') }}
                                        <span class="fillable"></span></label>
                                    <select
                                        class="nice-select niceSelect bordered_style wide @error('religion') is-invalid @enderror"
                                        name="religion" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('student_info.select_religion') }}</option>
                                        @foreach ($data['religions'] as $item)
                                            <option {{ @$data['student']->religion_id == $item->id ? 'selected' : '' }}
                                                value="{{ $item->id }}">{{ $item->name }}
                                        @endforeach
                                    </select>

                                    @error('religion')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                                <div class="col-md-3">

                                    <label for="validationServer04" class="form-label">{{ ___('common.gender') }} <span
                                            class="fillable"></span></label>
                                    <select
                                        class="nice-select niceSelect bordered_style wide @error('gender') is-invalid @enderror"
                                        name="gender" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('student_info.select_gender') }}</option>
                                        @foreach ($data['genders'] as $item)
                                            <option {{ @$data['student']->gender_id == $item->id ? 'selected' : '' }}
                                                value="{{ $item->id }}">{{ $item->name }}
                                        @endforeach
                                    </select>

                                    @error('gender')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                                <div class="col-md-3">

                                    <label for="validationServer04" class="form-label">{{ ___('common.category') }} <span
                                            class="fillable"></span></label>
                                    <select
                                        class="nice-select niceSelect bordered_style wide @error('category') is-invalid @enderror"
                                        name="category" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('student_info.select_category') }}</option>
                                        @foreach ($data['categories'] as $item)
                                            <option
                                                {{ @$data['student']->student_category_id == $item->id ? 'selected' : '' }}
                                                value="{{ $item->id }}">{{ $item->name }}
                                        @endforeach
                                    </select>

                                    @error('category')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                                <div class="col-md-3">

                                    <label for="validationServer04" class="form-label">{{ ___('student_info.blood') }}
                                        <span class="fillable"></span></label>
                                    <select
                                        class="nice-select niceSelect bordered_style wide @error('blood') is-invalid @enderror"
                                        name="blood" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('student_info.select_blood') }}</option>
                                        @foreach ($data['bloods'] as $item)
                                            <option {{ @$data['student']->blood_group_id == $item->id ? 'selected' : '' }}
                                                value="{{ $item->id }}">{{ $item->name }}
                                        @endforeach
                                    </select>

                                    @error('blood')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList"
                                        class="form-label ">{{ ___('student_info.admission_date') }} <span
                                            class="fillable">*</span></label>
                                    <input type="date"
                                        class="form-control ot-input @error('admission_date') is-invalid @enderror"
                                        name="admission_date" list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('student_info.admission_date') }}"
                                        value="{{ old('admission_date', @$data['student']->admission_date) }}">
                                    @error('admission_date')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('common.image') }}
                                        {{ ___('common.(100 x 100 px)') }}<span class="fillable"></span></label>


                                    <div class="ot_fileUploader left-side mb-3">
                                        <input class="form-control" type="text"
                                            placeholder="{{ ___('common.image') }}" readonly="" id="placeholder">
                                        <button class="primary-btn-small-input" type="button">
                                            <label class="btn btn-lg ot-btn-primary"
                                                for="fileBrouse">{{ ___('common.browse') }}</label>
                                            <input type="file" class="d-none form-control" name="image"
                                                id="fileBrouse" accept="image/*">
                                        </button>
                                    </div>

                                </div>
                                <div class="col-md-3 parent">

                                    <label for="validationServer04"
                                        class="form-label">{{ ___('student_info.select_parent') }}
                                        <span class="fillable">*</span></label>
                                    <select
                                        class="parent nice-select niceSelect bordered_style wide @error('parent') is-invalid @enderror"
                                        name="parent" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('student_info.select_parent') }}</option>
                                        @foreach ($data['parentGuardians'] as $parentGuardian)
                                            <option {{ @$data['student']->parent_guardian_id == $parentGuardian->id ? 'selected' : '' }} value="{{ $parentGuardian->id }}">
                                                {{ $parentGuardian->guardian_name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('parent')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label"
                                        for="#">{{ ___('frontend.attend_school_previously') }} </label>
                                    <div class="input-check-radio academic-section mt-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="previous_school"
                                                value="1" id="previous_school"
                                                {{ @$data['student']->previous_school ? 'checked' : '' }}>
                                            <label class="form-check-label ps-2 pe-5"
                                                for="previous_school">{{ ___('common.Yes') }}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 d-none mb-3" id="previous_school_info">
                                    <label class="form-label"
                                        for="#">{{ ___('frontend.previous_school_information') }} </label>
                                    <textarea class="form-control" rows="2" name="previous_school_info">{{ old('previous_school_info', @$data['student']->previous_school_info) }}</textarea>

                                </div>

                                <div class="col-xl-3 d-none mb-3" id="previous_school_doc">
                                    <label for="exampleDataList"
                                        class="form-label">{{ ___('frontend.previous_school_documents') }}<span
                                            class="fillable"></span>

                                    </label>

                                    <div class="ot_fileUploader left-side mb-3">
                                        <input class="form-control" type="text"
                                            placeholder="{{ ___('common.image') }}" readonly="" id="placeholder1">
                                        <button class="primary-btn-small-input" type="button">
                                            <label class="btn btn-lg ot-btn-primary"
                                                for="fileBrouse1">{{ ___('common.browse') }}</label>
                                            <input type="file" class="d-none form-control"
                                                name="previous_school_image" id="fileBrouse1" accept="image/*">
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">{{ ___('frontend.Place_Of_Birth') }} </label>
                                    <input name="place_of_birth" placeholder="{{ ___('frontend.Place_Of_Birth') }}"
                                        class="email form-control ot-input mb_30" type="text"
                                        value="{{ old('place_of_birth', @$data['student']->place_of_birth) }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">{{ ___('frontend.Student_Nationality') }}
                                    </label>
                                    <input name="nationality" placeholder="{{ ___('frontend.Student_Nationality') }}"
                                        value="{{ old('nationality', @$data['student']->nationality) }}"
                                        class="email form-control ot-input mb_30" type="text">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">{{ ___('frontend.CPR_Number') }} </label>
                                    <input name="cpr_no" placeholder="{{ ___('frontend.CPR_Number') }}"
                                        value="{{ old('cpr_no', @$data['student']->cpr_no) }}"
                                        class="email form-control ot-input mb_30" type="text">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">{{ ___('frontend.Student_Sponken_Language_At_Home') }}

                                    </label>
                                    <input name="spoken_lang_at_home"
                                        placeholder="{{ ___('frontend.Student_Sponken_Language_At_Home') }}"
                                        value="{{ old('spoken_lang_at_home', @$data['student']->spoken_lang_at_home) }}"
                                        class="email form-control ot-input mb_30" type="text">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">{{ ___('frontend.Residance_Address') }} </label>
                                    <input name="residance_address"
                                        placeholder="{{ ___('frontend.Residance_Address') }}"
                                        class="email form-control ot-input mb_30" type="text"
                                        value="{{ old('residance_address', @$data['student']->residance_address) }}">
                                </div>

                                <div class="col-md-3">

                                    <label for="validationServer04" class="form-label">{{ ___('common.status') }} <span
                                            class="fillable">*</span></label>
                                    <select
                                        class="nice-select niceSelect bordered_style wide @error('status') is-invalid @enderror"
                                        name="status" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option
                                            {{ @$data['student']->status == App\Enums\Status::ACTIVE ? 'selected' : '' }}
                                            value="{{ App\Enums\Status::ACTIVE }}">{{ ___('common.active') }}
                                        </option>
                                        <option
                                            {{ @$data['student']->status == App\Enums\Status::INACTIVE ? 'selected' : '' }}
                                            value="{{ App\Enums\Status::INACTIVE }}">{{ ___('common.inactive') }}
                                        </option>
                                    </select>

                                    @error('status')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">{{ ___('frontend.ID_Certificate') }} </label>
                                    <input name="student_id_certificate"
                                        placeholder="{{ ___('frontend.ID_Certificate') }}"
                                        class="email form-control ot-input mb_30" type="text"
                                        value="{{ old('student_id_certificate', @$data['student']->student_id_certificate) }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">{{ ___('frontend.Emergency_Contact') }} </label>
                                    <input name="emergency_contact"
                                        placeholder="{{ ___('frontend.Emergency_Contact') }}"
                                        class="email form-control ot-input mb_30" type="text"
                                        value="{{ old('emergency_contact', @$data['student']->emergency_contact) }}">
                                </div>


                                <div class="col-md-3 mb-3">
                                    <label for="HealthStatus" class="form-label ">{{ ___('common.Health Status') }}</label>
                                    <input type="text"
                                           class="form-control ot-input @error('health_status') is-invalid @enderror"
                                           name="health_status" id="HealthStatus"
                                           placeholder="{{ ___('common.Health Status') }}"
                                           value="{{ old('health_status', @$data['student']->health_status) }}">
                                    @error('health_status')
                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="rank_in_family" class="form-label ">{{ ___('common.Rank in family') }}</label>
                                    <input type="number"
                                           class="form-control ot-input @error('rank_in_family') is-invalid @enderror"
                                           name="rank_in_family" id="rank_in_family"
                                           placeholder="{{ ___('common.1st child, 2nd child ...') }}"
                                           value="{{ old('rank_in_family', @$data['student']->rank_in_family) }}">
                                    @error('rank_in_family')
                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="siblings" class="form-label ">{{ ___('common.Number of brothers/sisters') }}</label>
                                    <input type="number"
                                           class="form-control ot-input @error('siblings') is-invalid @enderror"
                                           name="siblings" id="siblings"
                                           placeholder="{{ ___('common.Number of brothers/sisters') }}"
                                           value="{{ old('siblings', @$data['student']->siblings) }}">
                                    @error('siblings')
                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex align-items-center gap-4 flex-wrap">
                                        <h3 class="m-0 flex-fill">
                                            {{ ___('student_info.upload_documents') }}
                                        </h3>
                                        <button type="button"
                                            class="btn btn-lg ot-btn-primary radius_30px small_add_btn addNewDocument"
                                            onclick="addNewDocument()">
                                            <span><i class="fa-solid fa-plus"></i> </span>
                                            {{ ___('common.add') }}</button>
                                        <input type="hidden" name="counter" id="counter"
                                            value="{{ count(@$data['student']->upload_documents ?? []) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table school_borderLess_table table_border_hide2"
                                            id="student-document">
                                            <thead>
                                                <tr>
                                                    <td scope="col">{{ ___('common.name') }} <span
                                                            class="text-danger"></span>
                                                        @if ($errors->any())
                                                            @if ($errors->has('school_user_name.*'))
                                                                <span
                                                                    class="custom-message">{{ 'the fields are required' }}
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td scope="col">
                                                        {{ ___('common.document') }}
                                                        <span class="text-danger"></span>
                                                        @if ($errors->any())
                                                            @if ($errors->has('school_user_telephone.*'))
                                                                <span
                                                                    class="custom-message">{{ 'the fields are required' }}
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td scope="col">
                                                        {{ ___('common.action') }}
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach (@$data['student']->upload_documents ?? [] as $key => $item)
                                                    <tr id="document-file">
                                                        <td>
                                                            <input type="text"
                                                                name="document_names[{{ $key }}]"
                                                                value="{{ $item['title'] }}"
                                                                class="form-control ot-input min_width_200 "
                                                                placeholder="{{ ___('student_info.enter_name') }}"
                                                                required>
                                                            <input type="hidden" name="document_rows[]"
                                                                value="{{ $key }}">

                                                        </td>
                                                        <td class="w-100 mw-50">
                                                            <div class="school_primary_fileUplaoder mb-3">
                                                                <label for="awesomefile{{ $key }}"
                                                                    class="filelabel">{{ ___('school.browse') }}</label>
                                                                <input type="file"
                                                                    name="document_files[{{ $key }}]"
                                                                    id="awesomefile{{ $key }}"
                                                                    value="{{ $item['file'] }}">
                                                                <input type="text" class="redonly_input" readonly
                                                                    placeholder="{{ ___('school.Document upload') }}">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <button class="drax_close_icon" onclick="removeRow(this)">
                                                                <i class="fa-solid fa-xmark"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>



                            <div class="row">
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
    <script>
        $(document).ready(function() {
            var fileInp1 = document.getElementById("fileBrouse1");
            if (fileInp1) {
                fileInp1.addEventListener("change", showFileName);

                function showFileName(event) {
                    var fileInp = event.srcElement;
                    var fileName = fileInp.files[0].name;
                    document.getElementById("placeholder1").placeholder = fileName;
                }
            }

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
