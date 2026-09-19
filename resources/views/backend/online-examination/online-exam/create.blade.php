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
                        <li class="breadcrumb-item"><a href="">{{ ___('online-examination.online_examination') }}</a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('online-exam.index') }}">{{ ___('online-examination.online_exam') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ ___('common.add_new') }}</li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('online-exam.store') }}" enctype="multipart/form-data" method="post" id="onlineExam">
                    @csrf
                    <div class="row mb-3">





                        <div class="col-md-4 mb-3">
                            <label for="exampleDataList" class="form-label ">{{ ___('common.name') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('name') is-invalid @enderror" name="name"
                                list="datalistOptions" id="exampleDataList" type="text"
                                placeholder="{{ ___('common.enter_name') }}" value="{{ old('name') }}">
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
                                placeholder="{{ ___('online-examination.Enter start') }}" value="{{ old('start') }}">
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
                                placeholder="{{ ___('online-examination.Enter end') }}" value="{{ old('end') }}">
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
                                placeholder="{{ ___('online-examination.Enter published') }}" value="{{ old('published') }}">
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
                                    <option {{ old('question_group') == $item->id ? 'selected':'' }} value="{{ $item->id }}">{{ $item->name }}</option>
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
                                    <option {{ old('class') == $item->class->id ? 'selected' : '' }} value="{{ $item->class->id }}">{{ $item->class->name }}
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
                                    @if (old('section') == $item->id)
                                        <option {{ old('section') == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}
                                    @endif
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
                                @foreach ($data['sections'] as $item)
                                    @if (old('subject') == $item->id)
                                        <option {{ old('subject') == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}
                                    @endif
                                @endforeach
                            </select>
                            @error('subject')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>





                        
                        <div class="col-md-4 mb-3">
                            <label for="exampleDataList" class="form-label ">{{ ___('online-examination.Total Mark') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('mark') is-invalid @enderror" name="mark"
                                list="datalistOptions" id="exampleDataList" type="number"
                                placeholder="{{ ___('online-examination.Enter total mark') }}" value="{{ old('mark') }}">
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
                                    <option {{ old('type') == $item->id ? 'selected':'' }} value="{{ $item->id }}">{{ $item->name }}</option>
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
                                <input type="hidden" id="page" value="create">
                                <table class="table table-bordered role-table" id="types_table">
                                    <thead class="thead">
                                        <tr>
                                            <th class="purchase mr-4">{{ ___('common.All') }} <input class="form-check-input all" type="checkbox"></th>
                                            <th class="purchase">{{ ___('online-examination.Question') }}</th>
                                            <th class="purchase">{{ ___('online-examination.Type') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbody"></tbody>
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
                                    <tbody class="tbody"></tbody>
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


@push('script')
    <script type="text/javascript">
        // online exam create time start
        $(document).ready(function () {
            var today = new Date().toISOString().slice(0, 16);

            $('input[name="start"]').attr('min', today);
            // $('input[name="end"]').attr('min', today);
            $('input[name="published"]').attr('min', today);

            $('input[name="end"]').on('click', function () {
                var startValue = $('input[name="start"]').val();
                if (startValue) {
                // $('input[name="end"]').attr('min', startValue);
                } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Please enter start time first'
                });
                }
            });

            $('input[name="published"]').on('click', function () {
                var endValue = $('input[name="end"]').val();
                if (endValue) {
                $('input[name="published"]').attr('max', endValue);
                } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Please enter end time first'
                });
                }
            });
        });
        // online exam create time end
    </script>
@endpush