@extends('backend.master')
@section('title')
    {{ $data['title'] }}
@endsection
@section('content')
    <div class="page-content">
        <div class="page-header mb-3">
            <h4>{{ $data['title'] }}</h4>
            <p class="text-muted mb-0">Send exam alerts to all students in the class/section. Students see them in their panel notifications.</p>
        </div>

        <div class="card ot-card mb-4">
            <div class="card-header"><h5>Offline exams (exam routine)</h5></div>
            <div class="card-body table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Subject</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Exam type</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data['offlineExams'] as $row)
                            <tr>
                                <td>{{ $row->examRoutine->class->name ?? '—' }}</td>
                                <td>{{ $row->examRoutine->section->name ?? '—' }}</td>
                                <td>{{ $row->subject->name ?? '—' }}</td>
                                <td>{{ $row->examRoutine->date ?? '—' }}</td>
                                <td>{{ $row->timeSchedule ? $row->timeSchedule->start_time.' - '.$row->timeSchedule->end_time : '—' }}</td>
                                <td>{{ $row->examRoutine->type->name ?? '—' }}</td>
                                <td>
                                    @if (hasPermission('teacher_exam_notification_create'))
                                        <form method="post" action="{{ route('teacher-exam-notification.send-offline') }}">
                                            @csrf
                                            <input type="hidden" name="exam_routine_child_id" value="{{ $row->id }}">
                                            <button type="submit" class="btn btn-sm ot-btn-primary">Notify students</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center">No offline exam slots for your subjects.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card ot-card mb-4">
            <div class="card-header"><h5>Online exams</h5></div>
            <div class="card-body table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Subject</th>
                            <th>Name</th>
                            <th>Start</th>
                            <th>End</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data['onlineExams'] as $exam)
                            <tr>
                                <td>{{ $exam->class->name ?? '—' }}</td>
                                <td>{{ $exam->section->name ?? '—' }}</td>
                                <td>{{ $exam->subject->name ?? '—' }}</td>
                                <td>{{ $exam->name ?? '—' }}</td>
                                <td>{{ $exam->start ?? '—' }}</td>
                                <td>{{ $exam->end ?? '—' }}</td>
                                <td>
                                    @if (hasPermission('teacher_exam_notification_create'))
                                        <form method="post" action="{{ route('teacher-exam-notification.send-online') }}">
                                            @csrf
                                            <input type="hidden" name="online_exam_id" value="{{ $exam->id }}">
                                            <button type="submit" class="btn btn-sm ot-btn-primary">Notify students</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center">No online exams for your subjects.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if (hasPermission('teacher_exam_notification_create'))
            <div class="card ot-card">
                <div class="card-header"><h5>Custom exam notification</h5></div>
                <div class="card-body">
                    <form method="post" action="{{ route('teacher-exam-notification.send-custom') }}" id="teacherExamNotifyForm" class="row g-3">
                        @csrf
                        <div class="col-md-3">
                            <label class="form-label">{{ ___('student_info.class') }} *</label>
                            <select id="getSections" name="class" class="nice-select niceSelect bordered_style wide class" required>
                                <option value="">{{ ___('student_info.select_class') }}</option>
                                @foreach ($data['classes'] as $item)
                                    <option value="{{ $item->class->id }}">{{ $item->class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">{{ ___('student_info.section') }} *</label>
                            <select id="getSubjects" name="section" class="nice-select niceSelect bordered_style wide sections section" required>
                                <option value="">{{ ___('student_info.select_section') }}</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">{{ ___('academic.subject') }} *</label>
                            <select id="subject" name="subject" class="nice-select niceSelect bordered_style wide subjects" required>
                                <option value="">{{ ___('examination.select_subject') }}</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Mode *</label>
                            <select name="exam_mode" class="form-control" required>
                                <option value="offline">Offline</option>
                                <option value="online">Online</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Exam date *</label>
                            <input type="date" name="exam_date" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Exam time *</label>
                            <input type="text" name="exam_time" class="form-control" placeholder="10:00 AM - 12:00 PM" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Exam type / title</label>
                            <input type="text" name="exam_type" class="form-control" placeholder="Midterm, Final, etc.">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn ot-btn-primary">Send notification</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
@endsection
