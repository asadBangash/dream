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
                                href="{{ route('fees-assign.index') }}">{{ $data['title'] }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ ___('common.add_new') }}</li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('fees-assign.store') }}" enctype="multipart/form-data" method="post" id="visitForm">
                    @csrf
                    <div class="row mb-3">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="validationServer04" class="form-label">{{ ___('fees.fees_group') }} <span
                                        class="fillable">*</span></label>
                                <select id="fees_group" class="nice-select niceSelect bordered_style wide @error('fees_group') is-invalid @enderror" name="fees_group"
                                    aria-describedby="validationServer04Feedback">
                                    <option value="">{{ ___('fees.select_fees_group') }}</option>
                                    @foreach ($data['fees_groups'] as $item)
                                        <option {{ old('fees_group') == $item->group->id ? 'selected':'' }} value="{{ $item->group->id }}">{{ $item->group->name }}</option>
                                    @endforeach
                                </select>
                                @error('fees_group')
                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-2 mb-3">
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
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <h3>{{ ___('student_info.fees_types') }}</h3>
                                <div class="table-responsive">
                                    <input type="hidden" id="page" value="create">
                                    <table class="table table-bordered role-table" id="types_table">
                                        <thead class="thead">
                                            <tr>
                                                <th class="purchase mr-4">{{ ___('common.All') }} <input class="form-check-input" type="checkbox" id="all_fees_masters"></th>
                                                <th class="purchase">{{ ___('common.name') }}</th>
                                                <th class="purchase">{{ ___('fees.amount') }} ({{ Setting('currency_symbol') }})</th>
                                            </tr>
                                        </thead>
                                        <tbody class="tbody"></tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-8 mb-3">
                                <h3>{{ ___('student_info.students_list') }} </h3>
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
                            </div>
                        </div>
                        <div class="col-md-12 mt-24">
                            <div class="text-end">
                                <button class="btn btn-lg ot-btn-primary"><span><i class="fa-solid fa-save"></i>
                                    </span>{{ ___('common.submit') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
