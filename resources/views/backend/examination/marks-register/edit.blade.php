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
                                href="{{ route('marks-register.index') }}">{{ $data['title'] }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ ___('common.edit') }}</li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('marks-register.update', @$data['marks_register']->id) }}" method="post"
                    id="visitForm">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="row">
                                {{-- {{dd($data['marks_register'])}} --}}
                                <div class="col-md-3 mb-3">
                                    <label for="validationServer04" class="form-label">{{ ___('student_info.class') }} <span
                                        class="fillable">*</span></label>
                                    <select id="getSections"
                                        class="nice-select niceSelect bordered_style wide @error('class') is-invalid @enderror"
                                        name="class" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('student_info.select_class') }}</option>
                                        @foreach ($data['classes'] as $item)
                                            <option {{ old('class',$data['marks_register']->classes_id) == $item->class->id ? 'selected' : '' }}
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
                                <div class="col-md-3 mb-3">
                                    <label for="validationServer04" class="form-label">{{ ___('student_info.section') }} <span
                                        class="fillable">*</span></label>
                                    <select id="getSubjects"
                                        class="nice-select niceSelect sections bordered_style wide @error('section') is-invalid @enderror"
                                        name="section" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('student_info.select_section') }}</option>
                                        @foreach ($data['sections'] as $item)
                                            @if ($data['marks_register']->section_id == $item->id)
                                                <option {{ old('section',$data['marks_register']->section_id) == $item->id ? 'selected' : '' }}
                                                value="{{ $item->id }}">{{ $item->name }}
                                            @endif
                                        @endforeach
                                    </select>

                                    @error('section')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-lg-3">
                                    <label for="validationServer04" class="form-label">{{ ___('examination.exam_type') }}
                                        <span class="fillable">*</span></label>
                                    <select class="nice-select niceSelect bordered_style wide @error('exam_type') is-invalid @enderror" name="exam_type">
                                        <option value="">{{ ___('examination.select_exam_type') }}</option>
                                        @foreach ($data['exam_types'] as $item)
                                            <option {{ old('class',$data['marks_register']->exam_type_id) == $item->exam_type->id ? 'selected' : '' }}
                                                value="{{ $item->exam_type->id }}">{{ $item->exam_type->name }}
                                        @endforeach
                                      </select>
                                      @error('exam_type')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="validationServer04" class="form-label">{{ ___('academic.subject') }} <span
                                        class="fillable">*</span></label>
                                    <select id="subject"
                                        class="form-control subjects wide nice-select bordered_style  @error('subject') is-invalid @enderror"
                                        name="subject">
                                        <option value="">{{ ___('examination.select_subject') }}</option>
                                        @foreach ($data['subjects'] as $item)
                                            @if ($data['marks_register']->subject_id == $item->id)
                                                <option {{ old('subject',$data['marks_register']->subject_id) == $item->id ? 'selected' : '' }}
                                                value="{{ $item->id }}">{{ $item->name }}
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('subject')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mt-24">
                                    <div class="table-responsive">
                                        <table class="table table-bordered role-table" id="students_table">
                                            <thead class="thead">
                                                <tr>
                                                    <th>{{ ___('student_info.student_name') }}</th>
                                                    <th>{{ ___('examination.total_mark') }}</th>
                                                    <th>{{ ___('examination.mark_distribution') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbody">
                                                @foreach ($data['students'] as $item)
                                                <tr id="document-file">
                                                    <input type="hidden" name="student_ids[]" value="{{ $item->student_id }}">
                                                    <td>
                                                        <p class="mt-3">{{ $item->student->first_name }} {{ $item->student->last_name }}</p>
                                                    </td>
                                                    <td>
                                                        <p class="mt-3">{{ @$data['examAssign']->total_mark }}</p>
                                                    </td>
                                                    <td>
                                                        @foreach (@$data['examAssign']->mark_distribution as $row)
                                                            <div class="row mb-1">
                                                                <div class="col-md-6">
                                                                    <p class="mt-3">{{ @$row->title }}</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    @foreach ($data['marks_register']->marksRegisterChilds as $child)
                                                                        @if ($child->student_id == $item->student_id && $child->title == $row->title)
                                                                            <input type="number" name="marks[{{ $item->student_id }}][{{ @$row->title }}]" value="{{$child->mark}}" class="form-control ot-input min_width_200" placeholder="{{ ___('examination.Enter mark out of') }} {{ @$row->mark }}" required>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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
    </div>
@endsection
