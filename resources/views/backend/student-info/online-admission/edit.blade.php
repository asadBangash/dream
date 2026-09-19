@extends('backend.master')
@section('css')
<style>
    .img-fluid-350{
        max-width: 350px !important;
        height: auto;
}
</style>
@endsection
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
                            <li class="breadcrumb-item active" aria-current="page">{{ $data['title'] }}</li>
                        </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}
    @if($data['student']->payment_status == 1)
        <div class="mb-3 card ot-card">
            <div class="alert alert-success">
                <span>{{___('common.Admission_Fees_Payment_Submitted')}}</span>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card p-2">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>{{ ___('fees.Assign Fees') }}</h4>
                        </div>
                        @isset($data['student']->fees->group->feeMasters)
                        <div class="table-responsive">
                            <table class="table table-bordered role-table">
                                <thead class="thead">
                                    <th class="w-50">{{ ___('fees.type') }}</th>
                                    <th>{{ ___('fees.amount') }} ({{ Setting('currency_symbol') }})</th>

                                </thead>
                                <tbody class="tbody">
                                    @foreach ($data['student']->fees->group->feeMasters as $key => $fees)
                                        <tr>
                                            <td>{{ @$fees->type->name }}</td>
                                            <td>{{ @$fees->amount }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <td>{{ ___('fees.Total') }} ({{ Setting('currency_symbol') }})</td>
                                    <td>{{$data['student']->fees->group->feeMasters->sum('amount')}}</td>
                                </tfoot>

                            </table>
                        </div>
                        @endisset
                    </div>

                </div>
                <div class="col-lg-6">

                    <div class="card p-2">
                        <div class="card-header d-flex justify-content-between align-items-center ">
                            <h4>{{ ___('fees.Assign Fees') }}</h4>
                        </div>
                        <div class="card-header">
                            <h5>{{ ___('fees.Payment Slip') }}</h5>

                        </div>
                        <div class="card-body">

                            <div class="pay-slip w-150">
                                <img src="{{@globalAsset(@$data['student']->payslip_img->path)}}" class="img-fluid-350">
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-end p-2">
                                <a class="btn btn-sm ot-btn-primary" href="{{@globalAsset(@$data['student']->payslip_img->path)}}" download><span><i class="fa-solid fa-save"></i>
                                </span>{{ ___('common.Download') }}</a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        @elseIf($data['student']->payment_status == 2)
            <div class="alert alert-danger">
                <span>{{___('common.Admission_Fees_Payment_Incomplete')}}</span>
            </div>
    @endif

        <div class="card ot-card">

            <div class="card-body">
                <form action="{{ route('online-admissions.store') }}" enctype="multipart/form-data" method="post"
                    id="visitForm">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-lg-12">

                            <input type="hidden" name="online_admission_id" value="{{@$data['student']->id}}">
                            <h2>Student Information</h2>
                            <div class="text-end">
                                <a href="javascript:void(0);"
                                onclick="delete_row('online-admissions/delete', {{ $data['student']->id}})"  class="btn btn-lg btn-danger"><span><i class="fa-solid fa-ban"></i>
                                    </span>{{ ___('common.Cancel') }}</a>
                            </div>
                            {{-- Start student information --}}
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('student_info.admission_no') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('admission_no') is-invalid @enderror"
                                        name="admission_no" list="datalistOptions" id="exampleDataList" type="number"
                                        placeholder="{{ ___('student_info.enter_admission_no') }}"
                                        value="{{ old('admission_no',@$data['student']->admission_no) }}">
                                    @error('admission_no')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('student_info.roll_no') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('roll_no') is-invalid @enderror"
                                        name="roll_no" list="datalistOptions" id="exampleDataList" type="number"
                                        placeholder="{{ ___('student_info.enter_roll_no') }}" value="{{ old('roll_no',@$data['student']->roll_no) }}">
                                    @error('roll_no')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('student_info.first_name') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('first_first_name') is-invalid @enderror"
                                        name="first_name" list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('student_info.enter_first_name') }}" value="{{ old('first_name',@$data['student']->first_name) }}">
                                    @error('first_name')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('student_info.last_name') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('last_name') is-invalid @enderror"
                                        name="last_name" list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('student_info.enter_last_name') }}" value="{{ old('last_name',@$data['student']->last_name) }}">
                                    @error('last_name')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('student_info.mobile') }} <span
                                            class="fillable"></span></label>
                                    <input class="form-control ot-input @error('mobile') is-invalid @enderror"
                                        name="mobile" list="datalistOptions" id="exampleDataList" type="text"
                                        placeholder="{{ ___('student_info.enter_mobile') }}" value="{{ old('mobile',@$data['student']->phone) }}">
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
                                        placeholder="{{ ___('student_info.enter_email') }}" value="{{ old('email',@$data['student']->email) }}">
                                    @error('email')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3">

                                    <label for="validationServer04" class="form-label">{{ ___('student_info.class') }} <span
                                            class="fillable">*</span></label>
                                    <select id="getSections"
                                        class="nice-select niceSelect bordered_style wide @error('class') is-invalid @enderror"
                                        name="class" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('student_info.select_class') }}</option>
                                        @foreach ($data['classes'] as $item)
                                            <option {{ @$data['student']->class->id == $item->class->id ? 'selected':''}} value="{{ $item->class->id }}">{{ $item->class->name }}
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
                                    <label for="validationServer04" class="form-label">{{ ___('student_info.section') }} <span
                                            class="fillable">*</span></label>
                                    <select id="getSections"
                                        class="nice-select sections niceSelect bordered_style wide @error('section') is-invalid @enderror"
                                        name="section" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('student_info.select_section') }}</option>
                                        @foreach ($data['sections'] as $item)
                                            <option {{ @$data['student']->section->id == $item->section->id ? 'selected':''}} value="{{ $item->section->id }}">{{ $item->section->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('section')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3">

                                    <label for="validationServer04" class="form-label">{{ ___('student_info.shift') }} <span
                                            class="fillable"></span></label>
                                    <select
                                        class="nice-select niceSelect bordered_style wide @error('shift') is-invalid @enderror"
                                        name="shift" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('student_info.select_shift') }}</option>
                                        @foreach ($data['shifts'] as $item)
                                            <option {{ @$data['student']->shift_id == $item->id ? 'selected':''}} value="{{ $item->id }}">{{ $item->name }}
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
                                        value="{{ old('date_of_birth',@$data['student']->dob) }}">
                                    @error('date_of_birth')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3">

                                    <label for="validationServer04" class="form-label">{{ ___('student_info.religion') }} <span
                                            class="fillable"></span></label>
                                    <select
                                        class="nice-select niceSelect bordered_style wide @error('religion') is-invalid @enderror"
                                        name="religion" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('student_info.select_religion') }}</option>
                                        @foreach ($data['religions'] as $item)
                                            <option {{ @$data['student']->religion_id == $item->id ? 'selected':''}} value="{{ $item->id }}">{{ $item->name }}
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
                                            <option {{ @$data['student']->gender_id == $item->id ? 'selected':''}} value="{{ $item->id }}">{{ $item->name }}
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
                                            <option {{ @$data['student']->student_category_id == $item->id ? 'selected':''}} value="{{ $item->id }}">{{ $item->name }}
                                        @endforeach
                                    </select>

                                    @error('category')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                                <div class="col-md-3">

                                    <label for="validationServer04" class="form-label">{{ ___('student_info.blood') }} <span
                                            class="fillable"></span></label>
                                    <select
                                        class="nice-select niceSelect bordered_style wide @error('blood') is-invalid @enderror"
                                        name="blood" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('student_info.select_blood') }}</option>
                                        @foreach ($data['bloods'] as $item)
                                            <option {{ @$data['student']->blood_group_id == $item->id ? 'selected':''}} value="{{ $item->id }}">{{ $item->name }}
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
                                        value="{{ old('admission_date',@$data['student']->admission_date) }}">
                                    @error('admission_date')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="exampleDataList"
                                        class="form-label ">{{ ___('common.image') }} {{ ___('common.(100 x 100 px)') }}<span
                                            class="fillable"></span></label>
                                            @isset($data['student']->student_img->path)
                                            <a class="btn btn-sm ot-btn-primary text-right"
                                                            href="#" data-bs-toggle="modal"
                                                            data-bs-target="#openCertificatePreviewModal" ><span
                                                                class="icon mr-8"><i
                                                                    class="fa-solid fa-eye"></i></span>
                                                            {{ ___('common.preview') }}</a>
                                                            @endisset


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


                                <div class="col-md-3">

                                    <label for="validationServer04" class="form-label">{{ ___('common.status') }} <span
                                            class="fillable">*</span></label>
                                    <select
                                        class="nice-select niceSelect bordered_style wide @error('status') is-invalid @enderror"
                                        name="status" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option {{ @$data['student']->status == App\Enums\Status::ACTIVE ? 'selected':'' }} value="{{ App\Enums\Status::ACTIVE }}">{{ ___('common.active') }}
                                        </option>
                                        <option {{ @$data['student']->status == App\Enums\Status::INACTIVE ? 'selected':'' }} value="{{ App\Enums\Status::INACTIVE }}">{{ ___('common.inactive') }}
                                        </option>
                                    </select>

                                    @error('status')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('frontend.CPR_Number') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('cpr_no') is-invalid @enderror"
                                        name="cpr_no" list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('frontend.CPR_Number') }}" value="{{ old('cpr_no',@$data['student']->cpr_no) }}">
                                    @error('cpr_no')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('frontend.Student_Sponken_Language_At_Home') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('spoken_lang_at_home') is-invalid @enderror"
                                        name="spoken_lang_at_home" list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('frontend.Student_Sponken_Language_At_Home') }}" value="{{ old('spoken_lang_at_home',@$data['student']->spoken_lang_at_home) }}">
                                    @error('spoken_lang_at_home')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('frontend.Student_Nationality') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('nationality') is-invalid @enderror"
                                        name="nationality" list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('frontend.Student_Nationality') }}" value="{{ old('nationality',@$data['student']->nationality) }}">
                                    @error('nationality')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('frontend.Father_Nationality') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('nationality') is-invalid @enderror"
                                        name="father_nationality" list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('frontend.Father_Nationality') }}" value="{{ old('father_nationality',@$data['student']->father_nationality) }}">
                                    @error('father_nationality')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('frontend.Place_Of_Birth') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('place_of_birth') is-invalid @enderror"
                                        name="place_of_birth" list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('frontend.Place_Of_Birth') }}" value="{{ old('place_of_birth',@$data['student']->place_of_birth) }}">
                                    @error('place_of_birth')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('frontend.Residance_Address') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('residance_address') is-invalid @enderror"
                                        name="residance_address" list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('frontend.Residance_Address') }}" value="{{ old('residance_address',@$data['student']->residance_address) }}">
                                    @error('residance_address')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex align-items-center gap-4 flex-wrap">
                                        <h5 class="mt-5 flex-fill">
                                            {{-- {{ ___('school.School name,and name, office address of Manager, Chairman,Secretary') }} --}}
                                            {{ ___('student_info.upload_documents') }}
                                        </h5>
                                        <button type="button" class="btn btn-lg ot-btn-primary radius_30px small_add_btn addNewDocument"
                                            onclick="addNewDocument()">
                                            <span><i class="fa-solid fa-plus"></i> </span>
                                            {{ ___('common.add') }}</button>
                                            <input type="hidden" name="counter" id="counter" value="0">
                                    </div>
                                </div>
                            </div>


                            <div class="row mb-5">

                                @if ($data['student']->upload_documents)
                                <table class="table school_borderLess_table table_border_hide2">
                                    <thead>
                                        <tr>
                                            <td scope="col">{{ ___('common.name') }} <span
                                                    class="text-danger"></span>
                                            </td>
                                            <td scope="col">{{___('common.Download')}} <span
                                                    class="text-danger"></span>
                                            </td>
                                        </tr>
                                        <tbody>
                                            @foreach ($data['student']->upload_documents as $key=>$item)
                                            @php
                                                $document = \App\Models\Upload::where('id', $item['file'])->first()?->path;
                                            @endphp
                                            <tr>
                                                <td>{{ $item['title'] }}</td>
                                                <td><a class="btn btn-primary" href="{{ @globalAsset($document) }}" download>{{___('common.Download')}}</a></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </thead>
                                </table>

                                @endif
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table school_borderLess_table table_border_hide2" id="student-document">
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

                                                    </td>
                                                </tr>
                                            </thead>
                                            <tbody>



                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            {{-- End student information --}}



                            {{-- Start parent information --}}

                            <h5>{{ ___('student_info.Parent Information') }}</h5>
                            {{-- father --}}
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('student_info.father_name') }} <span
                                            class="fillable"></span></label>
                                    <input class="form-control ot-input @error('father_name') is-invalid @enderror" name="father_name"
                                        list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('student_info.enter_father_name') }}" type="text" value="{{  @$data['student']->father_name ?? old('father_name') }}">
                                    @error('father_name')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('student_info.father_mobile') }} <span
                                            class="fillable"></span></label>
                                    <input class="form-control ot-input @error('father_mobile') is-invalid @enderror" name="father_mobile"
                                        list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('student_info.enter_father_mobile') }}" type="text" value="{{ @$data['student']->father_phone ?? old('father_mobile') }}">
                                    @error('father_mobile')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('student_info.father_profession') }} <span
                                            class="fillable"></span></label>
                                    <input class="form-control ot-input @error('father_profession') is-invalid @enderror" name="father_profession"
                                        list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('student_info.enter_father_profession') }}" type="text" value="{{ @$data['student']->father_profession ?? old('father_profession') }}">
                                    @error('father_profession')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">

                                    <label class="form-label" for="inputImage">{{ ___('student_info.father_image') }} {{ ___('common.(95 x 95 px)') }}</label>
                                    <div class="ot_fileUploader left-side mb-3">
                                        <input class="form-control" type="text" placeholder="{{ ___('student_info.father_image') }}" readonly="" id="placeholder2">
                                        <button class="primary-btn-small-input" type="button">
                                            <label class="btn btn-lg ot-btn-primary" for="fileBrouse2">{{ ___('common.browse') }}</label>
                                            <input type="file" class="d-none form-control" name="father_image" id="fileBrouse2" accept="image/*">
                                        </button>
                                    </div>

                                </div>
                            </div>
                            {{-- end father --}}
                            {{-- mother --}}
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('student_info.mother_name') }} <span
                                            class="fillable"></span></label>
                                    <input class="form-control ot-input @error('mother_name') is-invalid @enderror" name="mother_name"
                                        list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('student_info.enter_mother_name') }}" type="text" value="{{ @$data['student']->mother_name ?? old('mother_name') }}">
                                    @error('mother_name')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('student_info.mother_mobile') }} <span
                                            class="fillable"></span></label>
                                    <input class="form-control ot-input @error('mother_mobile') is-invalid @enderror" name="mother_mobile"
                                        list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('student_info.enter_mother_mobile') }}" type="text" value="{{ @$data['student']->mother_phone ?? old('mother_mobile') }}">
                                    @error('mother_mobile')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('student_info.mother_profession') }} <span
                                            class="fillable"></span></label>
                                    <input class="form-control ot-input @error('mother_profession') is-invalid @enderror" name="mother_profession"
                                        list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('student_info.enter_father_profession') }}" type="text" value="{{ @$data['student']->mother_profession ?? old('mother_profession') }}">
                                    @error('mother_profession')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">

                                    <label class="form-label" for="inputImage">{{ ___('student_info.mother_image') }} {{ ___('common.(95 x 95 px)') }}</label>
                                    <div class="ot_fileUploader left-side mb-3">
                                        <input class="form-control" type="text" placeholder="{{ ___('student_info.mother_image') }}" readonly="" id="placeholder3">
                                        <button class="primary-btn-small-input" type="button">
                                            <label class="btn btn-lg ot-btn-primary" for="fileBrouse3">{{ ___('student_info.browse') }}</label>
                                            <input type="file" class="d-none form-control" name="mother_image" id="fileBrouse3" accept="image/*">
                                        </button>
                                    </div>

                                </div>
                            </div>
                            {{-- end mother --}}
                            {{-- guardian --}}
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('student_info.guardian_name') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('guardian_name') is-invalid @enderror" name="guardian_name"
                                        list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('student_info.enter_guardian_name') }}" type="text" value="{{ old('guardian_name',$data['student']->guardian_name) }}">
                                    @error('guardian_name')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('student_info.guardian_mobile') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('guardian_mobile') is-invalid @enderror" name="guardian_mobile"
                                        list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('student_info.enter_guardian_mobile') }}" type="text" value="{{ old('guardian_mobile',$data['student']->guardian_phone) }}">
                                    @error('guardian_mobile')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('student_info.guardian_profession') }} <span
                                            class="fillable"></span></label>
                                    <input class="form-control ot-input @error('guardian_profession') is-invalid @enderror" name="guardian_profession"
                                        list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('student_info.enter_guardian_profession') }}" type="text" value="{{  @$data['student']->guardian_profession ?? old('guardian_profession') }}">
                                    @error('guardian_profession')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">

                                    <label class="form-label" for="inputImage">{{ ___('student_info.guardian_image') }} {{ ___('common.(95 x 95 px)') }}</label>
                                    <div class="ot_fileUploader left-side mb-3">
                                        <input class="form-control" type="text" placeholder="{{ ___('student_info.guardian_image') }}" readonly="" id="placeholder4">
                                        <button class="primary-btn-small-input" type="button">
                                            <label class="btn btn-lg ot-btn-primary" for="fileBrouse4">{{ ___('student_info.browse') }}</label>
                                            <input type="file" class="d-none form-control" name="guardian_image" id="fileBrouse4" accept="image/*">
                                        </button>
                                    </div>

                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('student_info.guardian_email') }}</label>
                                    <input class="form-control ot-input @error('guardian_email') is-invalid @enderror" name="guardian_email"
                                        list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('student_info.enter_guardian_email') }}" type="email" value="{{ @$data['student']->guardian_email ?? old('guardian_email') }}">
                                    @error('guardian_email')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('student_info.guardian_address') }} <span
                                            class="fillable"></span></label>
                                    <input class="form-control ot-input @error('guardian_address') is-invalid @enderror" name="guardian_address"
                                        list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('student_info.enter_guardian_address') }}" type="text" value="{{ old('guardian_address') }}">
                                    @error('guardian_address')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('student_info.guardian_relation') }} <span
                                            class="fillable"></span></label>
                                    <input class="form-control ot-input @error('guardian_relation') is-invalid @enderror" name="guardian_relation"
                                        list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('student_info.enter_guardian_relation') }}" type="text" value="{{ old('guardian_relation') }}">
                                    @error('guardian_relation')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3">

                                    <label for="validationServer04" class="form-label">{{ ___('student_info.status') }} <span class="fillable">*</span></label>
                                    <select class="nice-select niceSelect bordered_style wide @error('status') is-invalid @enderror"
                                    name="status" id="validationServer04"
                                    aria-describedby="validationServer04Feedback">
                                        <option value="{{ App\Enums\Status::ACTIVE }}">{{ ___('student_info.active') }}</option>
                                        <option value="{{ App\Enums\Status::INACTIVE }}">{{ ___('student_info.inactive') }}
                                        </option>
                                    </select>

                                    @error('status')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                            </div>
                            {{-- end guardian --}}



                            {{-- Previous school information --}}

                            @if ($data['student']->previous_school)

                            {{-- father --}}
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('student_info.previous_school_information') }} <span
                                            class="fillable"></span></label>
                                    <input class="form-control ot-input @error('father_name') is-invalid @enderror" name="previous_school_info"
                                        list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('student_info.previous_school_information') }}" type="text" value="{{  @$data['student']->previous_school_info ?? old('previous_school_info') }}">
                                    @error('previous_school_info')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-nd-12 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('student_info.Previous School Document') }} <span
                                        class="fillable"></span></label>

                                        <div class="card p-2">

                                            <div class="card-body">
                                                <img class="img-fluid-350" src="{{@globalAsset(@$data['student']->previous_img->path)}}">
                                            </div>
                                            <div class="card-footer">
                                                <div class="text-end p-2">
                                                    <a class="btn btn-sm ot-btn-primary" href="{{@globalAsset(@$data['student']->previous_img->path)}}" download><span><i class="fa-solid fa-save"></i>
                                                    </span>{{ ___('common.Download') }}</a>
                                                </div>
                                            </div>
                                        </div>

                                </div>

                            </div>
                            @endif


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


    {{-- image view modal  --}}


    <div id="view-modal">
        <div class="modal fade" id="openCertificatePreviewModal" tabindex="-1" aria-labelledby="modalWidth"
            aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content" id="modalWidth">
                    <div class="modal-header modal-header-image">
                        <h5 class="modal-title" id="modalLabel2">
                            {{ ___('common.Preview') }}
                        </h5>
                        <button type="button" class="m-0 btn-close d-flex justify-content-center align-items-center"
                            data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times text-white" aria-hidden="true"></i></button>
                    </div>

                        <div class="modal-body p-5">
                            <div class="col-lg-12">
                                <img class="w-100" src="{{ @globalAsset(@$data['student']->student_img->path, '40X40.webp') }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a class="button ot-btn-primary" class="btn-md" download href="{{@globalAsset(@$data['student']->student_img->path)}}">
                                <span><i class="fa-solid fa-save"></i>
                                                    </span>{{ ___('common.Download') }}
                                                </a>
                        </div>
                </div>

            </div>
        </div>
    </div>

@endsection



@push('script')
<script type="text/javascript">
    function delete_row(route, row_id, reload = true) {

        var table_row = '#row_' + row_id;
        var url = "{{url('')}}"+'/'+route+'/'+row_id;
        Swal.fire({
            title: $('#alert_title').val(),
            text: $('#alert_subtitle').val(),
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: $('#alert_yes_btn').val(),
            cancelButtonText: $('#alert_cancel_btn').val(),
          }).then((confirmed) => {
            if (confirmed.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: row_id,
                        _method: 'DELETE'
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                })
                .done(function(response) {

                    Swal.fire({
                        icon: response[1],
                        title: response[2],
                        text: response[0],
                        showCloseButton: true,
                        confirmButtonText: response[3],
                    });
                    $(table_row).fadeOut(2000);

                    if (reload) {
                        // reload

                        setTimeout(function() {
                            window.location.href = "{{route('online-admissions.index')}}";
                        }, 500);

                    }

                })
                .fail(function(error) {
                    console.log(error);
                    Swal.fire('{{ ___('common.opps') }}...', '{{ ___('common.something_went_wrong_with_ajax') }}', 'error');
                })
            }
        });

    };
</script>
@endpush
