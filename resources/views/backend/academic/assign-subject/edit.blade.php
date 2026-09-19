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
                                href="{{ route('assign-subject.index') }}">{{ $data['title'] }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ ___('common.update') }}</li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('assign-subject.update',$data['subject_assign']->id) }}" enctype="multipart/form-data" method="post" id="visitForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="form_type" id="form_type" value="update" />
                    <input type="hidden" name="id" id="id" value="{{$data['subject_assign']->id}}" />
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="validationServer04" class="form-label">{{ ___('academic.class') }} <span class="fillable">*</span></label>
                                        <select id="getSections" class="nice-select niceSelect select-class bordered_style wide @error('class') is-invalid @enderror"
                                        name="class" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                            <option {{ @$data['disabled'] ? 'disabled':'' }} value="">{{ ___('student_info.select_class') }}</option>
                                            @foreach ($data['classes'] as $item)
                                                <option {{ @$data['subject_assign']->classes_id == $item->id ? 'selected':(@$data['disabled'] ? 'disabled':'') }} value="{{ $item->class->id }}">{{ $item->class->name }}</option>
                                            @endforeach
                                        </select>
    
                                        @error('class')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div id="show_sections">
                                            <label for="validationServer04" class="form-label">{{ ___('academic.section') }} <span class="fillable">*</span></label>
                                            <select onchange="return changeSection(this)" class="nice-select niceSelect sections bordered_style wide @error('section') is-invalid @enderror"
                                            name="section" id="validationServer04"
                                            aria-describedby="validationServer04Feedback">
                                                <option {{ @$data['disabled'] ? 'disabled':'' }} value="">{{ ___('student_info.select_section') }}</option>
                                                @foreach ($data['sections'] as $item)
                                                    <option {{ @$data['subject_assign']->section_id == $item->section_id ? 'selected':(@$data['disabled'] ? 'disabled':'') }} value="{{ $item->section_id }}">{{ $item->section->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('section')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="validationServer04" class="form-label">{{ ___('common.status') }} <span class="fillable">*</span></label>
                                        <select class="nice-select niceSelect bordered_style wide @error('status') is-invalid @enderror"
                                        name="status" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                            <option {{ @$data['subject_assign']->status == App\Enums\Status::ACTIVE ? 'selected':(@$data['disabled'] ? 'disabled':'') }} value="{{ App\Enums\Status::ACTIVE }}">{{ ___('common.active') }}</option>
                                            <option {{ @$data['subject_assign']->status == App\Enums\Status::INACTIVE ? 'selected':(@$data['disabled'] ? 'disabled':'') }} value="{{ App\Enums\Status::INACTIVE }}">{{ ___('common.inactive') }}
                                            </option>
                                        </select>
    
                                        @error('status')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    

                                    
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="d-flex align-items-center gap-4 flex-wrap">
                                                <h5 class="m-0 flex-fill">
                                                    {{ ___('common.add') }} {{ ___('academic.subject_and_teacher') }}
                                                </h5>
                                                <button type="button" class="btn btn-lg ot-btn-primary radius_30px addSubjectTeacher"
                                                    onclick="addSubjectTeacher()">
                                                    <span><i class="fa-solid fa-plus"></i> </span>
                                                    {{ ___('academic.add') }}</button>
                                                <input type="hidden" name="counter" id="counter" value="1">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table school_borderLess_table table_border_hide2" id="subject-teacher">
                                                    <thead>
                                                        <tr>
                                                            <td scope="col">{{ ___('academic.subject') }} <span
                                                                    class="text-danger"></span>
                                                                @if ($errors->any())
                                                                    @if ($errors->has('subjects.*'))
                                                                        <span class="text-danger">{{ 'The fields are required' }}
                                                                    @endif
                                                                @endif
                                                            </td>
                                                            <td scope="col">
                                                                {{ ___('academic.teacher') }}
                                                                <span class="text-danger"></span>
                                                                @if ($errors->any())
                                                                    @if ($errors->has('teachers.*'))
                                                                        <span class="text-danger">{{ 'The fields are required' }}
                                                                    @endif
                                                                @endif
                                                            </td>
                                                            <td scope="col">
        
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($data['all_subject_assign'] as $key=>$item)
                                                            <tr>
                                                                <td>
                                                                    <select class="nice-select bordered_style wide @error('subjects') is-invalid @enderror"
                                                                        name="subjects[]" id="subject{{$key}}">
                                                                        <option {{ @$data['assignSubjects'][$key] == 1 ? 'disabled':'' }} value="">{{ ___('academic.select_subject') }}</option>
                                                                        @foreach ($data['subjects'] as $item)
                                                                            <option {{ @$data['subject_assign']->subjectTeacher[$key]->subject->id == $item->id ? 'selected':(@$data['assignSubjects'][$key] == 1 ? 'disabled':'') }} value="{{ $item->id }}">{{ $item->name }}</option>
                                                                        @endforeach
                                                                    </select> 
                                                                </td>
                                                                <td>
                                                                    <select class="nice-select bordered_style wide @error('teachers') is-invalid @enderror"
                                                                        name="teachers[]" id="teacher{{$key}}">
                                                                        <option {{ @$data['assignSubjects'][$key] == 1 ? 'disabled':'' }} value="">{{ ___('academic.select_teacher') }}</option>
                                                                        @foreach ($data['teachers'] as $item)
                                                                            <option {{ @$data['subject_assign']->subjectTeacher[$key]->teacher->id == $item->id ? 'selected':(@$data['assignSubjects'][$key] == 1 ? 'disabled':'') }} value="{{ $item->id }}">{{ $item->first_name }} {{ $item->last_name }}</option>
                                                                        @endforeach
                                                                    </select> 
                                                                </td>
                                                                <td>
                                                                    @if ($data['assignSubjects'][$key] == 0)
                                                                        <button class="drax_close_icon" onclick="removeRow(this)">
                                                                            <i class="fa-solid fa-xmark"></i>
                                                                        </button>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-24">
                                    <div class="text-end">
                                        <button class="btn btn-lg ot-btn-primary"><span><i class="fa-solid fa-save"></i> </span>{{ ___('common.submit') }}</button>
                                    </div>
                                </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection
