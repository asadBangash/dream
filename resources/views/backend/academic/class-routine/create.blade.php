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
                                    href="{{ route('class-routine.index') }}">{{ $data['title'] }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ ___('common.add_new') }}</li>
                        </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('class-routine.store') }}" enctype="multipart/form-data" method="post"
                    id="classRoutineForm">
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
                                    <label for="validationServer04" class="form-label">{{ ___('academic.shift') }} </label>
                                    <select
                                        class="shift nice-select niceSelect bordered_style wide @error('shift') is-invalid @enderror"
                                        name="shift" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('student_info.select_shift') }}</option>
                                        @foreach ($data['shifts'] as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('shift')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="validationServer04" class="form-label">{{ ___('academic.day') }} <span
                                            class="fillable">*</span></label>
                                    <select
                                        class="day nice-select niceSelect bordered_style wide @error('day') is-invalid @enderror"
                                        name="day" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('student_info.select_day') }}</option>
                                        @foreach (\Config::get('site.days') as $key => $day)
                                            <option {{ old('day') == $day ? 'selected' : '' }} value="{{ $key }}">
                                                {{ ___($day) }}</option>
                                        @endforeach
                                    </select>

                                    @error('day')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <div class="d-flex align-items-center gap-4 flex-wrap">
                                        <h5 class="m-0 flex-fill">
                                            {{ ___('academic.add_subject_teacher_time_room') }}
                                        </h5>
                                        <button type="button" class="btn btn-lg ot-btn-primary radius_30px small_add_btn"
                                            onclick="addClassRoutine()">
                                            <span><i class="fa-solid fa-plus"></i> </span>
                                            {{ ___('common.add') }}</button>
                                        <input type="hidden" name="counter" id="counter" value="0">
                                    </div>
                                </div>


                                <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table school_borderLess_table table_border_hide2" id="class-routines">
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
