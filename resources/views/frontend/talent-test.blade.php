@extends('frontend.master')
@section('title')
    {{ $data['config']['title'] ?? ___('frontend.talent_test') }}
@endsection

@section('main')
    <div class="breadcrumb_area" data-background="{{ @globalAsset(@$sections['study_at']->upload->path, '1920X700.webp') }}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-7">
                    <div class="breadcam_wrap text-center">
                        <h3>{{ $data['config']['title'] }}</h3>
                        <div class="custom_breadcam">
                            <a href="{{ url('/') }}" class="breadcrumb-item">{{ ___('frontend.home') }}</a>
                            <a href="#" class="breadcrumb-item">{{ ___('frontend.talent_test') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="search_result_area section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="card ot-card mb_30 p-4">
                        <p class="mb-2"><strong>{{ ___('frontend.test_date') }}:</strong> {{ $data['config']['test_date'] }}</p>
                        <p class="mb-4"><strong>{{ ___('frontend.test_venue') }}:</strong> {{ $data['config']['test_venue'] }}</p>

                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @elseif (session('message'))
                            <div class="alert alert-success">{{ session('message') }}</div>
                        @endif

                        <form action="{{ route('frontend.talent-test.store') }}" method="post">
                            @csrf
                            <h5 class="mb-3">{{ ___('frontend.student_information') }}</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="primary_label2">{{ ___('frontend.student_name') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="student_name" class="form-control ot-input" value="{{ old('student_name') }}" required>
                                    @error('student_name')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="primary_label2">{{ ___('frontend.father_name') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="father_name" class="form-control ot-input" value="{{ old('father_name') }}" required>
                                    @error('father_name')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="primary_label2">{{ ___('frontend.date_of_birth') }} <span class="text-danger">*</span></label>
                                    <input type="date" name="dob" class="form-control ot-input" value="{{ old('dob') }}" required>
                                    @error('dob')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="primary_label2 d-block">{{ ___('frontend.Gender') }} <span class="text-danger">*</span></label>
                                    <div class="d-flex gap-4 mt-2">
                                        <label class="d-flex align-items-center gap-2">
                                            <input type="radio" name="gender" value="1" {{ old('gender') == '1' ? 'checked' : '' }} required> {{ ___('frontend.Male') }}
                                        </label>
                                        <label class="d-flex align-items-center gap-2">
                                            <input type="radio" name="gender" value="2" {{ old('gender') == '2' ? 'checked' : '' }} required> {{ ___('frontend.Female') }}
                                        </label>
                                    </div>
                                    @error('gender')<small class="text-danger d-block">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="primary_label2">{{ ___('frontend.phone_no') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="contact_number" class="form-control ot-input" value="{{ old('contact_number') }}" required>
                                    @error('contact_number')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="primary_label2">{{ ___('frontend.guardian_contact') }}</label>
                                    <input type="text" name="guardian_contact" class="form-control ot-input" value="{{ old('guardian_contact') }}">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="primary_label2">{{ ___('frontend.home_address') }} <span class="text-danger">*</span></label>
                                    <textarea name="home_address" class="form-control ot-input" rows="2" required>{{ old('home_address') }}</textarea>
                                    @error('home_address')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>

                            <h5 class="mb-3 mt-2">{{ ___('frontend.academic_information') }}</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="primary_label2">{{ ___('frontend.current_class') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="current_class" class="form-control ot-input" value="{{ old('current_class') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="primary_label2">{{ ___('frontend.school_name') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="school_name" class="form-control ot-input" value="{{ old('school_name') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="primary_label2">{{ ___('frontend.last_examination_marks') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="last_exam_marks" class="form-control ot-input" value="{{ old('last_exam_marks') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="primary_label2">{{ ___('frontend.total_marks') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="total_marks" class="form-control ot-input" value="{{ old('total_marks') }}" required>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="theme_btn min_windth_200">{{ ___('common.submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
