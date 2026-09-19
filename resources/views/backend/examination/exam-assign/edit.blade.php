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
                        <li class="breadcrumb-item"><a href="{{ route('religions.index') }}">{{ $data['title'] }}</a></li>
                        <li class="breadcrumb-item">{{ ___('common.edit') }}</li>

                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('exam-assign.update', @$data['exam_assign']->id) }}" enctype="multipart/form-data" method="post"
                    id="visitForm">
                    <input type="hidden" name="form_type" id="form_type" value="update" />
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="validationServer04" class="form-label">{{ ___('examination.exam_type') }}
                                        <span class="fillable">*</span></label>
                                    <select class="nice-select niceSelect bordered_style wide  @error('exam_types') is-invalid @enderror" name="exam_types">
                                        <option value="">{{ ___('examination.select_exam_type') }}</option>
                                            @foreach ($data['exam_types'] as $item)
                                                <option {{ old('exam_types', @$data['exam_assign']->exam_type_id) == $item->id ? 'selected' : '' }}
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
                                        class="nice-select niceSelect bordered_style class wide @error('class') is-invalid @enderror"
                                        name="class" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('student_info.select_class') }}</option>
                                        @foreach ($data['classes'] as $item)
                                            <option {{ old('class',@$data['exam_assign']->classes_id) == $item->id ? 'selected' : '' }}
                                                value="{{ $item->id }}">{{ $item->name }}
                                        @endforeach
                                        </option>
                                    </select>

                                    @error('class')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                                {{-- {{dd($data['exam_assign'])}} --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ ___('academic.section') }} <span class="fillable">*</span></label>
                                    <div class="input-check-radio academic-section exam-assign-section">
                                        @foreach ($data['sections'] as $item)
                                        <div class='form-check'>
                                           <input class='form-check-input sections' onclick='return checkSection(this)' type='checkbox' {{$item->section_id == @$data['exam_assign']->section_id ? 'checked':''}} name='sections' value="{{$item->section_id}}" id='flexCheckDefault' />
                                            <label class='form-check-label ps-2 pe-5' for='flexCheckDefault'>{{$item->section->name}}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>


                                <div class="col-md-6 mb-3">

                                    <label for="validationServer04" class="form-label">{{ ___('examination.subjects') }} <span
                                            class="fillable">*</span></label>
                                    <select id="subjectMark"
                                        class="nice-select niceSelect bordered_style wide subjects @error('subjects') is-invalid @enderror"
                                        name="subjects" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('examination.select_subject') }}</option>
                                            @foreach ($data['subjects'] as $key=>$item)

                                                    <option {{ old('subjects', @$data['exam_assign']->subject_id) == $item->subject_id ? 'selected' : '' }}
                                                    value="{{ $item->subject_id }}">{{ $item->subject->name }}</option>

                                            @endforeach
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
                                        <table class="table school_borderLess_table " id="subject_marks_distribute">
                                            <thead>
                                                <tr>
                                                    <td scope="col">{{ ___('examination.subject') }}<span class="text-danger"></span>  </td>
                                                    <td scope="col"> {{ ___('examination.mark_distribution') }} <span class="text-danger"></span> </td>
                                                </tr>
                                            </thead>
                                            <tbody id="main">
                                                <tr>
                                                    <td>
                                                        <p class="mark_distribution_p">{{ @$data['exam_assign']->subject->name }}</p>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center justify-content-between mt-0">
                                                            <div></div>
                                                            <button type="button" class="btn btn-lg ot-btn-primary radius_30px small_add_btn"
                                                            onclick="marksDistribution({{@$data['exam_assign']->subject->id}})">
                                                            <span><i class="fa-solid fa-plus"></i> </span>
                                                            {{ ___('academic.add') }}</button>
                                                        </div>
                                                        <table class="table table_border_hide" id="marks-distribution{{@$data['exam_assign']->subject->id}}">
                                                            @foreach (@$data['exam_assign']->mark_distribution as $key=>$item)
                                                                <tr>
                                                                    <td>
                                                                        <div class="school_primary_fileUplaoder">
                                                                            <input type="text" name="marks_distribution[{{@$data['exam_assign']->subject->id}}][titles][]" class="redonly_input" value="{{ $item->title }}" placeholder="{{ ___("examination.title") }}">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="school_primary_fileUplaoder">
                                                                            <input type="number" step="any" name="marks_distribution[{{@$data['exam_assign']->subject->id}}][marks][]" class="redonly_input" value="{{ $item->mark }}" placeholder="{{ ___("examination.marks") }}">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <button class="drax_close_icon mark_distribution_close" onclick="removeRow(this)">
                                                                            <i class="fa-solid fa-xmark"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </table>
                                                    </td>
                                                </tr>
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
