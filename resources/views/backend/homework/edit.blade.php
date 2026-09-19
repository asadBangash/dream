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
                                href="{{ route('homework.index') }}">{{ $data['title'] }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ ___('common.edit') }}</li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}
        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('homework.update', [$data['homework']->id]) }}" enctype="multipart/form-data" method="post" id="markRegister">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="row">

                                <div class="col-md-4 mb-3">
                                    <label for="validationServer04" class="form-label">{{ ___('student_info.class') }} <span
                                        class="fillable">*</span></label>
                                    <select id="getSections"
                                        class="nice-select niceSelect bordered_style wide class @error('class') is-invalid @enderror"
                                        name="class" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('student_info.select_class') }}</option>
                                        @foreach ($data['classes'] as $item)
                                            <option {{ old('class', $data['homework']->classes_id) == $item->class->id ? 'selected' : '' }}
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
                                <div class="col-md-4 mb-3">
                                    <label for="validationServer04" class="form-label">{{ ___('student_info.section') }} <span
                                        class="fillable">*</span></label>
                                    <select id="getSubjects"
                                        class="nice-select niceSelect sections bordered_style wide section @error('section') is-invalid @enderror"
                                        name="section" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('student_info.select_section') }}</option>
                                        @foreach ($data['sections'] as $item)
                                            <option {{ old('section', $data['homework']->section_id) == $item->section_id ? 'selected' : '' }}
                                                value="{{ $item->section_id }}">{{ $item->section->name }}
                                        @endforeach
                                        </option>
                                    </select>

                                    @error('section')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="validationServer04" class="form-label">{{ ___('academic.subject') }} <span
                                        class="fillable">*</span></label>
                                    <select id="subject"
                                        class="nice-select niceSelect subjects bordered_style wide @error('subject') is-invalid @enderror"
                                        name="subject" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('examination.select_subject') }}</option>
                                        @foreach ($data['subjects'] as $item)
                                            <option {{ old('subject', $data['homework']->subject_id) == $item->subject_id ? 'selected' : '' }}
                                                value="{{ $item->subject_id }}">{{ $item->subject->name }}
                                        @endforeach
                                    </select>

                                    @error('subject')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('account.date') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('date') is-invalid @enderror" name="date" type="date"
                                        value="{{ old('date', $data['homework']->date) }}" list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('common.enter_date') }}">
                                    @error('date')
                                        <div id="validationServer06Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('common.submission_date') }} <span
                                            class="fillable"></span></label>
                                    <input class="form-control ot-input @error('date') is-invalid @enderror" name="submission_date" type="date"
                                        value="{{ old('submission_date', $data['homework']->submission_date) }}" list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('common.enter_submission_date') }}">
                                    @error('submission_date')
                                        <div id="validationServer06Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('examination.marks') }} </label>
                                    <input class="form-control ot-input @error('marks') is-invalid @enderror" name="marks"
                                        value="{{ old('marks', $data['homework']->marks) }}" list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('examination.marks') }}">
                                    @error('marks')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleDataList"
                                        class="form-label ">{{ ___('common.document') }} <span
                                            class="fillable"></span></label>
                                    <div class="ot_fileUploader left-side mb-3">
                                        <input class="form-control" type="text"
                                            placeholder="{{ ___('common.document') }}" readonly="" id="placeholder">
                                        <button class="primary-btn-small-input" type="button">
                                            <label class="btn btn-lg ot-btn-primary"
                                                for="fileBrouse">{{ ___('common.browse') }}</label>
                                            <input type="file" class="d-none form-control" name="document"
                                                id="fileBrouse">
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">

                                    <label for="validationServer04" class="form-label">{{ ___('common.status') }} <span class="fillable">*</span></label>
                                    <select class="nice-select niceSelect bordered_style wide @error('status') is-invalid @enderror"
                                    name="status" id="validationServer04"
                                    aria-describedby="validationServer04Feedback">
                                        <option value="{{ App\Enums\Status::ACTIVE }}" {{$data['homework']->status == App\Enums\Status::ACTIVE ? 'selected':''}}>{{ ___('common.active') }}</option>
                                        <option value="{{ App\Enums\Status::INACTIVE }}" {{$data['homework']->status == App\Enums\Status::INACTIVE ? 'selected':''}}>{{ ___('common.inactive') }}
                                        </option>
                                    </select>

                                    @error('status')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('account.description') }}</label>
                                    <textarea class="form-control ot-textarea @error('description') is-invalid @enderror" name="description"
                                    list="datalistOptions" id="exampleDataList"
                                    placeholder="{{ ___('account.enter_description') }}">{{ old('description', $data['homework']->description) }}</textarea>
                                    @error('description')
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
