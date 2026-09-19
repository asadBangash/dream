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
                        <li class="breadcrumb-item"><a href="">{{ ___('online-examination.online_examination') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('online-exam.index') }}">{{ ___('online-examination.online_exam') }}</a></li>
                        <li class="breadcrumb-item">{{ ___('common.edit') }}</li>

                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

{{-- @dd(@$data['online_exam']->examQuestions) --}}

        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('online-exam.update', @$data['online_exam']->id) }}" enctype="multipart/form-data" method="post"
                    id="onlineExam">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">


                        
                        <div class="col-md-4 mb-3">
                            <label for="exampleDataList" class="form-label ">{{ ___('common.name') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('name') is-invalid @enderror" name="name"
                                list="datalistOptions" id="exampleDataList" type="text"
                                placeholder="{{ ___('common.enter_name') }}" value="{{ old('name',@$data['online_exam']->name) }}">
                            @error('name')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="exampleDataList" class="form-label ">{{ ___('online-examination.Start') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('start') is-invalid @enderror" name="start" type="datetime-local"
                                list="datalistOptions" id="exampleDataList" type="text"
                                placeholder="{{ ___('online-examination.Enter start') }}" value="{{ old('start', @$data['online_exam']->start) }}">
                            @error('start')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="exampleDataList" class="form-label ">{{ ___('online-examination.End') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('end') is-invalid @enderror" name="end" type="datetime-local"
                                list="datalistOptions" id="exampleDataList" type="text"
                                placeholder="{{ ___('online-examination.Enter end') }}" value="{{ old('end', @$data['online_exam']->end) }}">
                            @error('end')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="exampleDataList" class="form-label ">{{ ___('online-examination.Published') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('published') is-invalid @enderror" name="published" type="datetime-local"
                                list="datalistOptions" id="exampleDataList" type="text"
                                placeholder="{{ ___('online-examination.Enter published') }}" value="{{ old('published', @$data['online_exam']->published) }}">
                            @error('published')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>





                        <div class="col-md-4 mb-3">
                            <label for="validationServer04" class="form-label">{{ ___('online-examination.Question group') }} <span
                                    class="fillable">*</span></label>
                            <select id="question_group" class="nice-select niceSelect bordered_style wide @error('question_group') is-invalid @enderror" name="question_group"
                                aria-describedby="validationServer04Feedback">
                                <option value="">{{ ___('online-examination.Select question group') }}</option>
                                @foreach ($data['question_groups'] as $item)
                                    <option {{ old('question_group', @$data['online_exam']->question_group_id) == $item->id ? 'selected':'' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('question_group')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationServer04" class="form-label">{{ ___('student_info.class') }} <span
                                    class="fillable">*</span></label>
                            <select id="getSections" class="nice-select niceSelect bordered_style wide @error('class') is-invalid @enderror" name="class"
                                aria-describedby="validationServer04Feedback">
                                <option value="">{{ ___('student_info.select_class') }}</option>
                                @foreach ($data['classes'] as $item)
                                    <option {{ old('class', @$data['online_exam']->classes_id ) == $item->class->id ? 'selected' : '' }} value="{{ $item->class->id }}">{{ $item->class->name }}
                                @endforeach
                                </option>
                            </select>
                            @error('class')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="validationServer04" class="form-label">{{ ___('student_info.section') }} <span
                                    class="fillable">*</span></label>
                            <select id="section" class="sections nice-select niceSelect bordered_style wide @error('section') is-invalid @enderror" name="section"
                                aria-describedby="validationServer04Feedback">
                                <option value="">{{ ___('student_info.select_section') }}</option>
                                @foreach ($data['sections'] as $item)
                                <option {{ old('section', @$data['online_exam']->section_id) == $item->section->id ? 'selected' : '' }} value="{{ $item->section->id }}">{{ $item->section->name }}
                                @endforeach
                            </select>
                            @error('section')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="validationServer04" class="form-label">{{ ___('online-examination.Subject') }}</label>
                            <select id="subject" class="subjects nice-select niceSelect bordered_style wide @error('subject') is-invalid @enderror" name="subject"
                                aria-describedby="validationServer04Feedback">
                                <option value="">{{ ___('online-examination.select_subject') }}</option>
                                @foreach ($data['subjects'] as $item)
                                <option {{ old('subject', @$data['online_exam']->subject_id) == $item->subject->id ? 'selected' : '' }} value="{{ $item->subject->id }}">{{ $item->subject->name }}
                                @endforeach
                            </select>
                            @error('subject')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>






                        <div class="col-md-4 mb-3">
                            <label for="exampleDataList" class="form-label ">{{ ___('online-examination.Mark') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('mark') is-invalid @enderror" name="mark"
                                list="datalistOptions" id="exampleDataList" type="number"
                                placeholder="{{ ___('online-examination.Enter mark') }}" value="{{ old('mark', @$data['online_exam']->total_mark) }}">
                            @error('mark')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationServer04" class="form-label">{{ ___('online-examination.Type') }}</label>
                            <select id="type" class="nice-select niceSelect bordered_style wide @error('type') is-invalid @enderror" name="type"
                                aria-describedby="validationServer04Feedback">
                                <option value="">{{ ___('online-examination.Select Type') }}</option>
                                @foreach ($data['types'] as $item)
                                    <option {{ old('type', @$data['online_exam']->exam_type_id ) == $item->id ? 'selected':'' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('type')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-2 mb-3">
                            <div>
                                <label for="validationServer04" class="form-label">{{ ___('student_info.student_category') }}</label>
                                <select id="student_category" class="nice-select student_category niceSelect bordered_style wide @error('student_category') is-invalid @enderror" name="student_category">
                                    <option value="">{{ ___('fees.select_student_category') }}</option>
                                    @foreach ($data['categories'] as $item)
                                        <option {{ old('student_category') == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}
                                    @endforeach
                                </select>
                            </div>
                            @error('student_category')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-2 mb-3">
                            <div>
                                <label for="validationServer04" class="form-label">{{ ___('fees.gender') }}</label>
                                <select id="gender" class="nice-select gender niceSelect bordered_style wide @error('gender') is-invalid @enderror" name="gender">
                                    <option value="">{{ ___('student_info.select_gender') }}</option>
                                    @foreach ($data['genders'] as $item)
                                        <option {{ old('gender') == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}
                                    @endforeach
                                </select>
                            </div>
                            @error('gender')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        {{-- First row end --}}





                        {{-- Second row --}}
                        <div class="col-md-4 mb-3">
                            <h5>{{ ___('online-examination.Question list') }}</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered role-table" id="types_table">
                                    <thead class="thead">
                                        <tr>
                                            <th class="purchase mr-4">{{ ___('common.All') }} <input class="form-check-input all" type="checkbox"></th>
                                            <th class="purchase">{{ ___('online-examination.Question') }}</th>
                                            <th class="purchase">{{ ___('online-examination.Type') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbody">
                                        @foreach ($data['questions'] as $item)
                                        <tr>
                                            <td><input class="form-check-input child" type="checkbox" name="questions_ids[]" value="{{$item->id}}" 
                                                {{ in_array($item->id, old('questions_ids',@$data['online_exam']->examQuestions->pluck('question_bank_id')->toArray())) ? 'checked' : '' }}></td>
                                            <td>{{ $item->question }}</td>
                                            <td>{{ ___(\Config::get('site.question_types')[$item->type]) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if ($errors->has('questions_ids'))
                                <span class="text-danger">{{ ___('online-examination.At least select one.') }}</span>
                            @endif
                        </div>
                        <div class="col-md-8 mb-3">
                            <h5>{{ ___('student_info.students_list') }} </h5>
                            <div class="table-responsive">
                                <table class="table table-bordered role-table" id="students_table">
                                    <thead class="thead">
                                        <tr>
                                            <th class="purchase mr-4">{{ ___('common.All') }} <input class="form-check-input" type="checkbox" id="all_students"></th>
                                            <th class="purchase">{{ ___('student_info.admission_no') }}</th>
                                            <th class="purchase">{{___('student_info.student_name') }}</th>
                                            <th class="purchase">{{ ___('academic.class') }} ({{ ___('academic.section') }})</th>
                                            <th class="purchase">{{ ___('student_info.guardian_name') }}</th>
                                            <th class="purchase">{{ ___('student_info.mobile_number') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbody">
                                        @foreach ($data['students'] as $item)
                                            <tr>
                                                <td>
                                                    <input class="form-check-input student" type="checkbox" name="student_ids[]" value="{{$item->id}}"
                                                    {{ in_array($item->student->id, old('student_ids',@$data['online_exam']->examStudents->pluck('student_id')->toArray())) ? 'checked' : '' }}>
                                                </td>
                                                <td>{{ @$item->student->admission_no }}</td>
                                                <td>{{ @$item->student->first_name }} {{ @$item->student->last_name }}</td>
                                                <td>{{ @$item->class->name }} ({{ @$item->section->name }})</td>
                                                <td>{{ @$item->student->parent->guardian_name }}</td>
                                                <td>{{ @$item->student->mobile }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if ($errors->has('student_ids'))
                                <span class="text-danger">{{ ___('online-examination.At least select one.') }}</span>
                            @endif
                        </div>
                        {{-- Second row end --}}
                        <div class="col-md-12 mt-24">
                            <div class="text-end">
                                <button class="btn btn-lg ot-btn-primary"><span><i class="fa-solid fa-save"></i>
                                    </span>{{ ___('common.submit') }}
                                </button>
                            </div>
                        </div>



                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
