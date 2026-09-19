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
                                    href="{{ route('exam-routine.index') }}">{{ $data['title'] }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ ___('common.update') }}</li>
                        </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('exam-routine.update', $data['exam_routine']->id) }}" enctype="multipart/form-data"
                    method="post" id="examRoutineForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="form_type" id="form_type" value="update" />
                    <input type="hidden" name="id" id="id" value="{{$data['exam_routine']->id}}" />
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="validationServer04" class="form-label">{{ ___('academic.class') }} <span
                                            class="fillable">*</span></label>
                                    <select id="getSections"
                                        class="class nice-select niceSelect bordered_style wide @error('class') is-invalid @enderror"
                                        name="class" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('student_info.select_class') }}</option>
                                        @foreach ($data['classes'] as $item)
                                            <option value="{{ $item->class->id }}" {{$data['exam_routine']->classes_id == $item->class->id ? 'selected':''}}>{{ $item->class->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('class')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div id="show_sections">
                                        <label for="validationServer04" class="form-label">{{ ___('academic.section') }}
                                            <span class="fillable">*</span></label>
                                        <select
                                            class="section nice-select niceSelect bordered_style sections wide @error('section') is-invalid @enderror"
                                            name="section" id="validationServer04"
                                            aria-describedby="validationServer04Feedback">
                                            <option value="">{{ ___('student_info.select_section') }}</option>
                                            @foreach ($data['sections'] as $item)
                                            <option value="{{ $item->section_id }}" {{$data['exam_routine']->section_id == $item->section_id ? 'selected':''}}>{{ $item->section->name }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    @error('section')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="validationServer04" class="form-label">{{ ___('academic.type') }} <span class="fillable">*</span></label>
                                    <select
                                        class="type nice-select niceSelect bordered_style wide @error('type') is-invalid @enderror"
                                        name="type" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('student_info.select_type') }}</option>
                                        @foreach ($data['types'] as $item)
                                            <option value="{{ $item->exam_type->id }}" {{$data['exam_routine']->type_id == $item->exam_type->id ? 'selected':''}}>{{ $item->exam_type->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('type')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('common.Date') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control date ot-input @error('date') is-invalid @enderror" name="date"
                                        list="datalistOptions" id="exampleDataList" type="date"
                                        placeholder="{{ ___('common.enter_date') }}" value="{{ old('date',$data['exam_routine']->date) }}">
                                    @error('date')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <div class="d-flex align-items-center gap-4 flex-wrap">
                                        <h3 class="m-0 flex-fill">
                                            {{ ___('academic.add_subject_teacher_time_room') }}
                                        </h3>
                                        <button type="button" class="btn btn-lg ot-btn-primary radius_30px addClassRoutine"
                                            onclick="addExamRoutine()">
                                            <span><i class="fa-solid fa-plus"></i> </span>
                                            {{ ___('academic.add') }}</button>
                                        <input type="hidden" name="counter" id="counter" value="{{count($data['exam_routine']->ExamRoutineChildren) - 1}}">
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table school_borderLess_table" id="exam-routines">
                                                <thead>
                                                    <tr>
                                                        <td scope="col">{{ ___('academic.subject') }} <span
                                                                class="text-danger"></span>
                                                            @if ($errors->any())
                                                                @if ($errors->has('subjects.*'))
                                                                    <span
                                                                        class="text-danger">{{ 'The fields are required' }}
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td scope="col">
                                                            {{ ___('academic.time_schedules.*') }}
                                                            <span class="text-danger"></span>
                                                            @if ($errors->any())
                                                                @if ($errors->has('time_schedules.*'))
                                                                    <span
                                                                        class="text-danger">{{ 'The fields are required' }}
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td scope="col">
                                                            {{ ___('academic.class_room') }}
                                                            <span class="text-danger"></span>
                                                            @if ($errors->any())
                                                                @if ($errors->has('class_rooms.*'))
                                                                    <span
                                                                        class="text-danger">{{ 'The fields are required' }}
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td scope="col">
                                                            {{ ___('common.action') }}
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- Add hear --}}
                                                    @foreach($data['exam_routine']->examRoutineChildren as $counter=>$child)
                                                    <tr id="document-file">
                                                        <td>
                                                            <select class="nice-select niceSelect bordered_style wide"
                                                                name="subjects[]" id="subject{{$counter}}" required>
                                                                <option value="">{{ ___('academic.select_subject') }}</option>
                                                                @foreach ($data['subjects'] as $item)
                                                                    <option value="{{ $item->subject->id }}" {{$child->subject_id == $item->subject->id ? 'selected':''}}>{{ $item->subject->name }}</option>
                                                                @endforeach
                                                            </select> 
                                                        </td>
                                                        <td>
                                                            <select class="nice-select niceSelect bordered_style wide"
                                                                name="time_schedules[]" id="teacher{{$counter}}" required>
                                                                <option value="">{{ ___('academic.select_time_schedule') }}</option>
                                                                @foreach ($data['time_schedules'] as $item)
                                                                    <option value="{{ $item->id }}" {{$child->time_schedule_id == $item->id ? 'selected':''}}>{{ $item->start_time }} - {{ $item->end_time }}</option>
                                                                @endforeach
                                                            </select> 
                                                        </td>
                                                        <td>
                                                            <select class="nice-select niceSelect bordered_style wide"
                                                                name="class_rooms[]" id="class_room{{$counter}}" required>
                                                                <option value="">{{ ___('academic.select_class_room') }}</option>
                                                                @foreach ($data['class_rooms'] as $item)
                                                                    <option value="{{ $item->id }}" {{$child->class_room_id == $item->id ? 'selected':''}}>{{ $item->room_no }}</option>
                                                                @endforeach
                                                            </select> 
                                                        </td>
                                                        <td>
                                                            <button class="drax_close_icon mark_distribution_close" onclick="removeRow(this)">
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
@endsection
