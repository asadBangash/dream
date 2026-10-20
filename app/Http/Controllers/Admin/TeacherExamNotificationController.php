<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Academic\ExamRoutineChildren;
use App\Models\OnlineExamination\OnlineExam;
use App\Repositories\Academic\ClassSetupRepository;
use App\Services\ClassSectionNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherExamNotificationController extends Controller
{
    public function __construct(
        private ClassSectionNotificationService $notifier,
        private ClassSetupRepository $classSetupRepo,
    ) {}

    public function index()
    {
        $sessionId = setting('session');
        $subjectIds = teacherSubjects();
        $data['classes'] = $this->classSetupRepo->all();

        $data['title'] = 'Examination Notifications';
        $data['offlineExams'] = ExamRoutineChildren::with([
            'subject', 'timeSchedule', 'examRoutine.class', 'examRoutine.section', 'examRoutine.type',
        ])
            ->whereIn('subject_id', $subjectIds ?: [0])
            ->whereHas('examRoutine', fn ($q) => $q->where('session_id', $sessionId))
            ->latest()
            ->limit(50)
            ->get();

        $data['onlineExams'] = OnlineExam::with(['class', 'section', 'subject', 'type'])
            ->where('session_id', $sessionId)
            ->whereIn('subject_id', $subjectIds ?: [0])
            ->where('status', 1)
            ->latest()
            ->limit(50)
            ->get();

        return view('backend.teacher-exam-notification.index', compact('data'));
    }

    public function sendOffline(Request $request)
    {
        $request->validate(['exam_routine_child_id' => 'required|integer']);

        $child = ExamRoutineChildren::with([
            'subject', 'timeSchedule', 'examRoutine.class', 'examRoutine.section', 'examRoutine.type',
        ])->findOrFail($request->exam_routine_child_id);

        $this->assertTeacherOwnsSubject((int) $child->subject_id);

        $routine = $child->examRoutine;
        $time = $child->timeSchedule
            ? ($child->timeSchedule->start_time.' - '.$child->timeSchedule->end_time)
            : '—';

        $message = sprintf(
            'Subject: %s | Date: %s | Time: %s | Type: Offline (%s)',
            $child->subject->name ?? '—',
            $routine->date ?? '—',
            $time,
            $routine->type->name ?? 'Exam'
        );

        $count = $this->notifier->notifyStudentsInClassSection(
            (int) $routine->classes_id,
            (int) $routine->section_id,
            'Examination Scheduled (Offline)',
            $message,
            route('student-panel-exam-routine.index')
        );

        return back()->with('success', "Notification sent to {$count} student(s).");
    }

    public function sendOnline(Request $request)
    {
        $request->validate(['online_exam_id' => 'required|integer']);

        $exam = OnlineExam::with(['class', 'section', 'subject', 'type'])->findOrFail($request->online_exam_id);
        $this->assertTeacherOwnsSubject((int) $exam->subject_id);

        $message = sprintf(
            'Subject: %s | Start: %s | End: %s | Type: Online (%s)',
            $exam->subject->name ?? '—',
            $exam->start ?? '—',
            $exam->end ?? '—',
            $exam->type->name ?? ($exam->name ?? 'Online Exam')
        );

        $count = $this->notifier->notifyStudentsInClassSection(
            (int) $exam->classes_id,
            (int) $exam->section_id,
            'Examination Scheduled (Online)',
            $message,
            route('student-panel-online-examination.index')
        );

        return back()->with('success', "Notification sent to {$count} student(s).");
    }

    public function sendCustom(Request $request)
    {
        $request->validate([
            'class'       => 'required|integer',
            'section'     => 'required|integer',
            'subject'     => 'required|integer',
            'exam_mode'   => 'required|in:online,offline',
            'exam_date'   => 'required|date',
            'exam_time'   => 'required|string|max:100',
            'exam_type'   => 'nullable|string|max:120',
        ]);

        $this->assertTeacherOwnsSubject((int) $request->subject);

        $modeLabel = $request->exam_mode === 'online' ? 'Online' : 'Offline';
        $message = sprintf(
            'Subject ID %s | Date: %s | Time: %s | Mode: %s | %s',
            $request->subject,
            $request->exam_date,
            $request->exam_time,
            $modeLabel,
            $request->exam_type ? 'Exam: '.$request->exam_type : ''
        );

        $url = $request->exam_mode === 'online'
            ? route('student-panel-online-examination.index')
            : route('student-panel-exam-routine.index');

        $count = $this->notifier->notifyStudentsInClassSection(
            (int) $request->class,
            (int) $request->section,
            "Examination Scheduled ({$modeLabel})",
            $message,
            $url
        );

        return back()->with('success', "Notification sent to {$count} student(s).");
    }

    private function assertTeacherOwnsSubject(int $subjectId): void
    {
        if (Auth::user()->role_id != 5) {
            return;
        }

        if (! in_array($subjectId, teacherSubjects(), true)) {
            abort(403, 'You are not assigned to this subject.');
        }
    }
}
