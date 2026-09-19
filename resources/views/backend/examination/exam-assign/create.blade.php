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
                                    href="{{ route('exam-assign.index') }}">{{ $data['title'] }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ ___('common.add') }}</li>
                        </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('exam-assign.store') }}" enctype="multipart/form-data" method="post" id="visitForm" onsubmit="return examAssignSubmit()">
                    @csrf
                    <input type="hidden" name="form_type" id="form_type" value="create" />
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="validationServer04" class="form-label">{{ ___('examination.exam_type') }}
                                        <span class="fillable">*</span></label>
                                    <select class="form-control exam_types select2_multy wide nice-select  @error('exam_types') is-invalid @enderror" name="exam_types[]" multiple="multiple">
                                        <option value="" disabled>{{ ___('examination.select_exam_type') }}</option>
                                        @foreach ($data['exam_types'] as $item)
                                        <option {{ old('class') == $item->id ? 'selected' : '' }}
                                            value="{{ $item->id }}">{{ $item->name }}
                                    @endforeach
                                      </select>
                                      @error('exam_types')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">

                                    <label for="validationServer04" class="form-label">{{ ___('student_info.class') }} <span
                                            class="fillable">*</span></label>
                                    <select onchange="changeExamAssignClass(this)"
                                        class="nice-select classes niceSelect bordered_style wide class @error('class') is-invalid @enderror"
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


                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ ___('academic.section') }} <span class="fillable">*</span></label>
                                    <div class="input-check-radio academic-section exam-assign-section">
                                    </div>
                                </div>



                                <div class="col-md-6 mb-3">

                                    <label for="validationServer04" class="form-label">{{ ___('examination.subjects') }} <span
                                            class="fillable">*</span></label>
                                    <select id="subjectMark"
                                        class="form-control subjects select2_multy wide nice-select bordered_style  @error('subjects') is-invalid @enderror"
                                        name="subjects[]" id="validationServer04"
                                        aria-describedby="validationServer04Feedback" multiple="multiple">
                                        <option value="" disabled>{{ ___('examination.select_subject') }}</option>
                                    </select>

                                    @error('subjects')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table school_borderLess_table" id="subject_marks_distribute">
                                            <thead>
                                                <tr>
                                                    <td scope="col">{{ ___('examination.subject') }}<span class="text-danger"></span>  </td>
                                                    <td scope="col"> {{ ___('examination.mark_distribution') }} <span class="text-danger"></span> </td>
                                                </tr>
                                            </thead>
                                            <tbody id="main">

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-12 mt-24">
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-lg ot-btn-primary"><span><i class="fa-solid fa-save"></i>
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
