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
                                    href="{{ route('student.index') }}">{{ ___('student_info.student_list') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ ___('common.add_new') }}</li>
                        </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}
        <div class="card ot-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0"> </h4>
                @if (hasPermission('student_create'))
                    <a href="{{ route('student.import') }}" class="btn btn-lg ot-btn-primary">
                        <span><i class="fa-solid fa-plus"></i> </span>
                        <span class="">{{ ___('common.Import') }}</span>
                    </a>
                @endif
            </div>


            <div class="card-body">
                <form action="{{ route('student.store') }}" enctype="multipart/form-data" method="post" id="visitForm">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('student_info.admission_no') }}
                                        <span class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('admission_no') is-invalid @enderror"
                                        type="number" name="admission_no" list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('student_info.enter_admission_no') }}"
                                        value="{{ old('admission_no') }}">
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
                                        value="{{ old('roll_no') }}">
                                    @error('roll_no')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('student_info.first_name') }}
                                        <span class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('first_name') is-invalid @enderror"
                                        name="first_name" list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('student_info.enter_first_name') }}"
                                        value="{{ old('first_name') }}">
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
                                        value="{{ old('last_name') }}">
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
                                        value="{{ old('student_ar_name') }}">
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('student_info.mobile') }} <span
                                            class="fillable"></span></label>
                                    <input class="form-control ot-input @error('mobile') is-invalid @enderror"
                                        name="mobile" list="datalistOptions" id="exampleDataList" type="number"
                                        placeholder="{{ ___('student_info.enter_mobile') }}" value="{{ old('mobile') }}">
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
                                        placeholder="{{ ___('student_info.enter_email') }}" value="{{ old('email') }}">
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
                                        value="{{ old('username') }}">
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
                                            <option {{ old('department_id') == $id ? 'selected' : '' }} value="{{ $id }}">{{ $name }} </option>
                                        @endforeach
                                    </select>

                                    @error('department_id')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <input type="hidden" id="siblings_discount" name="siblings_discount" value="0">
                                <div class="col-md-3">

                                    <label for="validationServer04" class="form-label">{{ ___('student_info.class') }}
                                        <span class="fillable">*</span></label>
                                    <select id="getSections"
                                        class="nice-select niceSelect bordered_style wide @error('class') is-invalid @enderror"
                                        name="class" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('student_info.select_class') }}</option>
                                        @foreach ($data['classes'] as $item)
                                            <option {{ old('class') == $item->id ? 'selected' : '' }}
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
                                            <option {{ old('shift') == $item->id ? 'selected' : '' }}
                                                value="{{ $item->id }}">{{ $item->name }}
                                        @endforeach
                                    </select>

                                    @error('status')
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
                                        value="{{ old('date_of_birth') }}">
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
                                            <option {{ old('religion') == $item->id ? 'selected' : '' }}
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
                                            <option {{ old('gender') == $item->id ? 'selected' : '' }}
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
                                            <option {{ old('category') == $item->id ? 'selected' : '' }}
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
                                            <option {{ old('blood') == $item->id ? 'selected' : '' }}
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
                                        value="{{ old('admission_date') }}">
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
                                <div class="col-md-3 parent mb-3">

                                    <label for="validationServer04"
                                        class="form-label">{{ ___('student_info.select_parent') }}
                                        <span class="fillable">*</span></label>
                                    <select
                                        class="parent nice-select niceSelect bordered_style wide @error('parent') is-invalid @enderror"
                                        name="parent" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('student_info.select_parent') }}</option>
                                        @foreach ($data['parentGuardians'] as $parentGuardian)
                                            <option {{ old('parent') == $parentGuardian->id ? 'selected' : '' }}
                                                value="{{ $parentGuardian->id }}">
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

                                <div>
                                    <h5 id="discount-alert" class="text-success text-center"></h5>
                                </div>
                                <div class="row mb-3" id="child-info"></div>


                                <div class="col-md-3 mb-3">
                                    <label class="form-label"
                                        for="#">{{ ___('frontend.attend_school_previously') }} </label>
                                    <div class="input-check-radio academic-section mt-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="previous_school"
                                                value="1" id="previous_school">
                                            <label class="form-check-label ps-2 pe-5"
                                                for="previous_school">{{ ___('common.Yes') }}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 d-none mb-3" id="previous_school_info">
                                    <label class="form-label"
                                        for="#">{{ ___('frontend.previous_school_information') }} </label>
                                    <textarea class="form-control" rows="2" name="previous_school_info"></textarea>

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
                                        class="email form-control ot-input mb_30" type="text">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">{{ ___('frontend.Student_Nationality') }}
                                    </label>
                                    <input name="nationality" placeholder="{{ ___('frontend.Student_Nationality') }}"
                                        class="email form-control ot-input mb_30" type="text">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">{{ ___('frontend.CPR_Number') }} </label>
                                    <input name="cpr_no" placeholder="{{ ___('frontend.CPR_Number') }}"
                                        class="email form-control ot-input mb_30" type="text">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">{{ ___('frontend.Student_Sponken_Language_At_Home') }}
                                    </label>
                                    <input name="spoken_lang_at_home"
                                        placeholder="{{ ___('frontend.Student_Sponken_Language_At_Home') }}"
                                        class="email form-control ot-input mb_30" type="text">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">{{ ___('frontend.Residance_Address') }} </label>
                                    <input name="residance_address"
                                        placeholder="{{ ___('frontend.Residance_Address') }}"
                                        class="email form-control ot-input mb_30" type="text">
                                </div>




                                <div class="col-md-3">

                                    <label for="validationServer04" class="form-label">{{ ___('common.status') }} <span
                                            class="fillable">*</span></label>
                                    <select
                                        class="nice-select niceSelect bordered_style wide @error('status') is-invalid @enderror"
                                        name="status" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option {{ old('status') ? 'selected' : '' }}
                                            value="{{ App\Enums\Status::ACTIVE }}">{{ ___('common.active') }}
                                        </option>
                                        <option {{ old('status') ? 'selected' : '' }}
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
                                        value="{{ old('student_id_certificate') }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">{{ ___('frontend.Emergency_Contact') }} </label>
                                    <input name="emergency_contact"
                                        placeholder="{{ ___('frontend.Emergency_Contact') }}"
                                        class="email form-control ot-input mb_30" type="text"
                                        value="{{ old('emergency_contact') }}">
                                </div>



                                <div class="col-md-3 mb-3">
                                    <label for="HealthStatus" class="form-label ">{{ ___('common.Health Status') }}</label>
                                    <input type="text"
                                        class="form-control ot-input @error('health_status') is-invalid @enderror"
                                        name="health_status" id="HealthStatus"
                                        placeholder="{{ ___('common.Health Status') }}"
                                        value="{{ old('health_status') }}">
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
                                        value="{{ old('rank_in_family', 1) }}">
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
                                        value="{{ old('siblings', 0) }}">
                                    @error('siblings')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="password"
                                            class="form-label">{{ ___('frontend.Password') }}
                                        </label> <br>
                                        <input type="radio" name="password_type" value="default" id=""
                                            checked> <span class="mr-4">{{ ___('frontend.Default Password') }}
                                            (123456)</span>
                                        <input type="radio" name="password_type" value="custom" id="">
                                        <span>{{ ___('frontend.Custom Password') }}</span>
                                    </div>
                                </div>


                                <div id="SelectionDiv" class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="password"
                                            class="form-label">{{ ___('frontend.Password') }}
                                        </label>
                                        <input type="text" name="password"
                                            placeholder="{{ ___('frontend.Password') }}" autocomplete="off"
                                            class="form-control ot-form-control ot-input" value="{{ old('password') }}"
                                            id="password">
                                        @if ($errors->has('password'))
                                            <div class="error text-danger">{{ $errors->first('password') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-24">
                                <div class="col-md-12">
                                    <div class="d-flex align-items-center gap-4 flex-wrap">
                                        <h3 class="m-0 flex-fill fs-4">
                                            {{ ___('student_info.upload_documents') }}
                                        </h3>
                                        <button type="button"
                                            class="btn btn-lg ot-btn-primary radius_30px small_add_btn addNewDocument"
                                            onclick="addNewDocument()">
                                            <span><i class="fa-solid fa-plus"></i> </span>
                                            {{ ___('common.add') }}</button>
                                        <input type="hidden" name="counter" id="counter" value="0">
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
                                                    <th scope="col">{{ ___('common.name') }} <span
                                                            class="text-danger"></span>
                                                        @if ($errors->any())
                                                            @if ($errors->has('document_names.*'))
                                                                <span class="text-danger">{{ 'the fields are required' }}
                                                            @endif
                                                        @endif
                                                    </th>
                                                    <th scope="col">
                                                        {{ ___('common.document') }}
                                                        <span class="text-danger"></span>
                                                        @if ($errors->any())
                                                            @if ($errors->has('document_files.*'))
                                                                <span class="text-danger">{{ 'The fields are required' }}
                                                            @endif
                                                        @endif
                                                    </th>
                                                    <th scope="col">
                                                        {{ ___('common.action') }}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>

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
                </form>
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

            // Initially hide the role selection div
            $('#SelectionDiv').hide();

            // Attach an event listener to the radio buttons
            $('input[name="password_type"]').on('change', function() {
                if ($(this).val() === 'custom') {

                    // If the 'custom' radio button is selected, show the role selection div
                    $('#SelectionDiv').show();
                } else {
                    // If the 'default' radio button is selected or other value, hide the  selection div
                    $('#SelectionDiv').hide();
                }
            });


        });

         $(document).ready(function () {
            $('.parent').on('change', function () {
                var parentId = $(this).val();
                if (parentId) {
                    $.ajax({
                        url: '/student/get-children/' + parentId,
                        type: 'GET',
                        dataType: 'json',
                        success: function (response) {
                            console.log(response)
                            if (response.status === 'success') {
                                let html = '';
                                if (response.data.siblingsCount > 0) {
                                    html += `
                                        <div class="card mb-4">
                                            <div class="card-header mt-3">
                                                <h5 class="mb-0 text-center">Siblings Information</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                    `;

                                    $.each(response.data.children, function (i, child) {
                                        html += `
                                        <div class="col-md-4 mb-3">
                                            <div class="card h-100 shadow-sm">
                                                <div class="card-body p-3">
                                                    <h5 class="card-title">${child.full_name}</h5>
                                                    <p class="mb-1"><strong>Admission No:</strong> ${child.admission_no}</p>
                                                    <p class="mb-1"><strong>Roll No:</strong> ${child.roll_no}</p>
                                                    <p class="mb-0"> <strong>Class: </strong> ${child.session_class_student.class.name}</p>
                                                    <p class="mb-1"><strong>DOB:</strong> ${child.dob}</p>
                                                    <p class="mb-1"><strong>Email:</strong> ${child.email}</p>
                                                    <p class="mb-1"><strong>Mobile:</strong> ${child.mobile}</p>
                                                    <p class="mb-0"><strong>Admission Date:</strong> ${child.admission_date}</p>
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                    });

                                    html += `
                </div>
            </div>
        </div>
    `;

                                    if (response.data.isEligible){
                                        $('#discount-alert').text('A ' + response.data.siblingDiscount + '% sibling discount will be applied to all assigned fees for this student.');
                                        $('#siblings_discount').val(response.data.isEligible ? 1 : 0);
                                        toastr.success('Student is eligible for sibling discount');
                                    }
                                }

                                $('#child-info').html(html);

                            }
                        }
                    });
                } else {
                    $('#child-info').html('');
                }
            });
        });

    </script>
@endpush
