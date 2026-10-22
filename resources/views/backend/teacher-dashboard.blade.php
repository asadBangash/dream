@extends('backend.master')
@section('title')
    {{ $data['title'] }}
@endsection
@section('content')
    <div class="page-content">
        <div class="page-header mb-3">
            <h4>{{ $data['title'] }}</h4>
        </div>

        <div class="row mb-4">
            <div class="col-xl-4 col-md-5 mb-3">
                <div class="ot-card h-100">
                    <div class="card-body text-center">
                        @php
                            $photo = $data['staff']?->upload ?? Auth::user()->upload;
                        @endphp
                        <img class="rounded-circle mb-3" width="120" height="120"
                            src="{{ $photo ? globalAsset($photo->path, '120X120.webp') : global_asset('backend/assets/images/crm/crm_summery1.svg') }}"
                            alt="{{ Auth::user()->name }}">
                        <h5 class="mb-1">{{ $data['staff']?->first_name }} {{ $data['staff']?->last_name }}</h5>
                        <p class="text-muted mb-1">{{ $data['staff']?->designation?->name ?? Auth::user()->role?->name }}</p>
                        <p class="text-muted mb-0">{{ $data['staff']?->department?->name ?? '' }}</p>
                        <p class="small text-muted mt-2">Staff ID: {{ $data['staff']?->staff_id ?? '—' }}</p>
                        <a href="{{ route('my.profile') }}" class="btn btn-sm ot-btn-primary mt-2">{{ ___('common.my_profile') }}</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-md-7 mb-3">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="ot_crm_summeryBox d-flex align-items-center">
                            <div class="summeryContent">
                                <h4>{{ ___('academic.subject') }}</h4>
                                <h1>{{ $data['subjectCount'] }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="ot_crm_summeryBox d-flex align-items-center">
                            <div class="summeryContent">
                                <h4>{{ ___('common.homeworks') }}</h4>
                                <h1>{{ $data['homeworkCount'] }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="ot_crm_summeryBox d-flex align-items-center">
                            <div class="summeryContent">
                                <h4>Lectures</h4>
                                <h1>{{ $data['lectureCount'] }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ot-card">
                    <div class="card-header"><h5>Assigned classes</h5></div>
                    <div class="card-body">
                        @if ($data['classNames']->isNotEmpty())
                            <p>{{ $data['classNames']->implode(', ') }}</p>
                        @else
                            <p class="text-muted mb-0">No subject assignments for this session yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-6 mb-3">
                <div class="ot-card">
                    <div class="card-header"><h5>My subjects (this session)</h5></div>
                    <div class="card-body table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Section</th>
                                    <th>Subject</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data['assignments'] as $row)
                                    <tr>
                                        <td>{{ $row->subjectAssign?->class?->name ?? '—' }}</td>
                                        <td>{{ $row->subjectAssign?->section?->name ?? '—' }}</td>
                                        <td>{{ $row->subject?->name ?? '—' }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted">No assignments</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 mb-3">
                <div class="ot-card">
                    <div class="card-header"><h5>{{ ___('dashboard.upcoming_events') }}</h5></div>
                    <div class="card-body">
                        @forelse ($data['events'] as $event)
                            <div class="mb-3 pb-2 border-bottom">
                                <strong>{{ $event->title }}</strong>
                                <div class="small text-muted">{{ dateFormat($event->date) }} | {{ timeFormat($event->start_time) }}</div>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No upcoming events.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="d-flex flex-wrap gap-2">
                    @if (hasPermission('homework_create'))
                        <a href="{{ route('homework.create') }}" class="btn ot-btn-primary">{{ ___('common.homeworks') }}</a>
                    @endif
                    @if (hasPermission('teacher_lecture_read'))
                        <a href="{{ route('teacher-lecture.index') }}" class="btn ot-btn-primary">Lecture Upload</a>
                    @endif
                    @if (hasPermission('teacher_exam_notification_read'))
                        <a href="{{ route('teacher-exam-notification.index') }}" class="btn ot-btn-primary">Exam Notifications</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
