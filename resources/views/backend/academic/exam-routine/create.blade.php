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
                            <li class="breadcrumb-item active" aria-current="page">{{ ___('common.add_new') }}</li>
                        </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('exam-routine.store') }}" enctype="multipart/form-data" method="post"
                    id="examRoutineForm">
                    @csrf
                    <input type="hidden" name="form_type" id="form_type" value="create" />
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
                                            <option value="{{ $item->class->id }}">{{ $item->class->name }}</option>
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
                                        </select>
                                        @error('section')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                               
                                <div class="col-md-3 mb-3">
                                    <label for="validationServer04" class="form-label">{{ ___('academic.type') }} <span class="fillable">*</span></label>
                                    <select
                                        class="nice-select niceSelect bordered_style wide exam_types @error('type') is-invalid @enderror"
                                        name="type" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('student_info.select_type') }}</option>
                                    </select>

                                    @error('type')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('common.date') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control date ot-input @error('date') is-invalid @enderror" name="date"
                                        list="datalistOptions" id="exampleDataList" type="date"
                                        placeholder="{{ ___('common.enter_date') }}" value="{{ old('date') }}">
                                    @error('date')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <div class="d-flex align-items-center gap-4 flex-wrap">
                                        <h3 class="m-0 flex-fill">
                                            {{ ___('academic.add_subject_time_room') }}
                                        </h3>
                                        <button type="button" class="btn btn-lg ot-btn-primary radius_30px"
                                            onclick="addExamRoutine()">
                                            <span><i class="fa-solid fa-plus"></i> </span>
                                            {{ ___('common.add') }}</button>
                                        <input type="hidden" name="counter" id="counter" value="0">
                                    </div>
                                </div>


                                <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table school_borderLess_table table_border_hide2" id="exam-routines">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">{{ ___('academic.subject') }} <span
                                                                class="text-danger"></span>
                                                            @if ($errors->any())
                                                                @if ($errors->has('subjects.*'))
                                                                    <span
                                                                        class="text-danger">{{ 'The fields are required' }}
                                                                @endif
                                                            @endif
                                                        </th>
                                                        <th scope="col">
                                                            {{ ___('academic.time_schedules.*') }}
                                                            <span class="text-danger"></span>
                                                            @if ($errors->any())
                                                                @if ($errors->has('time_schedules.*'))
                                                                    <span
                                                                        class="text-danger">{{ 'The fields are required' }}
                                                                @endif
                                                            @endif
                                                        </th>
                                                        <th scope="col">
                                                            {{ ___('academic.class_room') }}
                                                            <span class="text-danger"></span>
                                                            @if ($errors->any())
                                                                @if ($errors->has('class_rooms.*'))
                                                                    <span
                                                                        class="text-danger">{{ 'The fields are required' }}
                                                                @endif
                                                            @endif
                                                        </th>
                                                        <th scope="col">
                                                            {{ ___('common.action') }}
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- Add hear --}}
                                                </tbody>
                                            </table>
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
