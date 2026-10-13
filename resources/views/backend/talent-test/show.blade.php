@extends('backend.master')
@section('title')
    {{ $data['title'] }}
@endsection
@section('content')
    @php $app = $data['application']; @endphp
    <div class="page-content">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="bradecrumb-title mb-1">{{ $data['title'] }}</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ ___('common.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('talent-test-applications.index') }}">{{ ___('settings.talent_test_applications') }}</a></li>
                        <li class="breadcrumb-item active">{{ $app->reference_no }}</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card ot-card mb-24">
                    <div class="card-header"><h5 class="mb-0">{{ ___('frontend.student_information') }}</h5></div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-4">{{ ___('common.reference') }}</dt><dd class="col-sm-8">{{ $app->reference_no }}</dd>
                            <dt class="col-sm-4">{{ ___('student_info.student_name') }}</dt><dd class="col-sm-8">{{ $app->student_name }}</dd>
                            <dt class="col-sm-4">{{ ___('frontend.father_name') }}</dt><dd class="col-sm-8">{{ $app->father_name }}</dd>
                            <dt class="col-sm-4">{{ ___('student_info.date_of_birth') }}</dt><dd class="col-sm-8">{{ dateFormat($app->dob) }}</dd>
                            <dt class="col-sm-4">{{ ___('student.Gender') }}</dt>
                            <dd class="col-sm-8">{{ (int) $app->gender === 1 ? ___('frontend.Male') : ___('frontend.Female') }}</dd>
                            <dt class="col-sm-4">{{ ___('frontend.phone_no') }}</dt><dd class="col-sm-8">{{ $app->contact_number }}</dd>
                            <dt class="col-sm-4">{{ ___('frontend.guardian_contact') }}</dt><dd class="col-sm-8">{{ $app->guardian_contact ?: '—' }}</dd>
                            <dt class="col-sm-4">{{ ___('frontend.home_address') }}</dt><dd class="col-sm-8">{{ $app->home_address }}</dd>
                        </dl>
                    </div>
                </div>
                <div class="card ot-card mb-24">
                    <div class="card-header"><h5 class="mb-0">{{ ___('frontend.academic_information') }}</h5></div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-4">{{ ___('frontend.current_class') }}</dt><dd class="col-sm-8">{{ $app->current_class }}</dd>
                            <dt class="col-sm-4">{{ ___('frontend.school_name') }}</dt><dd class="col-sm-8">{{ $app->school_name }}</dd>
                            <dt class="col-sm-4">{{ ___('frontend.last_examination_marks') }}</dt><dd class="col-sm-8">{{ $app->last_exam_marks }} / {{ $app->total_marks }}</dd>
                            <dt class="col-sm-4">{{ ___('common.submitted') }}</dt><dd class="col-sm-8">{{ dateFormat($app->created_at) }} {{ timeFormat($app->created_at) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                @if (hasPermission('admission_update'))
                    <div class="card ot-card">
                        <div class="card-header"><h5 class="mb-0">{{ ___('common.action') }}</h5></div>
                        <div class="card-body">
                            <form action="{{ route('talent-test-applications.update-status', $app->id) }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">{{ ___('common.status') }}</label>
                                    <select name="status" class="nice-select niceSelect bordered_style wide">
                                        @foreach ($data['statuses'] as $value => $label)
                                            <option value="{{ $value }}" {{ (int) $app->status === (int) $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">{{ ___('common.remarks') }}</label>
                                    <textarea name="admin_remarks" class="form-control ot-input" rows="4">{{ old('admin_remarks', $app->admin_remarks) }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-lg ot-btn-primary w-100">{{ ___('common.update') }}</button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
