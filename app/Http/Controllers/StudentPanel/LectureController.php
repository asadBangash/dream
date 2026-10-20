<?php

namespace App\Http\Controllers\StudentPanel;

use App\Http\Controllers\Controller;
use App\Models\StudentInfo\SessionClassStudent;
use App\Repositories\TeacherLectureRepository;
use Illuminate\Support\Facades\Auth;

class LectureController extends Controller
{
    public function __construct(private TeacherLectureRepository $repo) {}

    public function index()
    {
        $studentId = \App\Models\StudentInfo\Student::withoutGlobalScopes()
            ->where('user_id', Auth::id())
            ->value('id');

        $enrollment = $studentId
            ? SessionClassStudent::withoutGlobalScopes()
                ->where('student_id', $studentId)
                ->where('session_id', setting('session'))
                ->first()
            : null;

        $data['title'] = 'Lectures & Study Material';
        $data['lectures'] = $enrollment
            ? $this->repo->forStudent((int) $enrollment->classes_id, (int) $enrollment->section_id)
            : collect();

        return view('student-panel.lectures', compact('data'));
    }
}
