<?php

namespace App\Repositories\StudentPanel;

use App\Models\Event;
use App\Models\StudentInfo\Student;
use Illuminate\Support\Facades\Auth;
use App\Models\Academic\ClassRoutine;
use App\Models\Academic\SubjectAssign;
use App\Models\Academic\SubjectAssignChildren;
use App\Models\StudentInfo\SessionClassStudent;
use App\Interfaces\StudentPanel\DashboardInterface;

class DashboardRepository implements DashboardInterface
{
    public function index()
    {
        try {
            $sessionId = (int) setting('session');
            $student = Student::withoutGlobalScopes()->where('user_id', Auth::id())->first();
            $classSection = $student
                ? SessionClassStudent::withoutGlobalScopes()
                    ->where('session_id', $sessionId)
                    ->where('student_id', $student->id)
                    ->first()
                : null;

            $subjectTeacher = $classSection
                ? SubjectAssign::where('session_id', $sessionId)
                    ->where('classes_id', $classSection->classes_id)
                    ->where('section_id', $classSection->section_id)
                    ->first()
                : null;
            $data['totalSubject']   = SubjectAssignChildren::where('subject_assign_id', @$subjectTeacher->id)
                            ->distinct('subject_id')
                            ->count();
            $data['totalTeacher']   = SubjectAssignChildren::where('subject_assign_id', @$subjectTeacher->id)
                            ->distinct('staff_id')
                            ->count();
            $data['totalClass']     = ClassRoutine::where('classes_id', @$classSection->classes_id)
                            ->where('section_id', @$classSection->section_id)
                            ->where('session_id', setting('session'))
                            ->count();
            $today = date('Y-m-d');
            $eventQuery = Event::query()
                ->where('session_id', $sessionId)
                ->active()
                ->where('date', '>=', $today)
                ->orderBy('date');

            $data['totalEvent'] = (clone $eventQuery)->count();
            $data['events'] = (clone $eventQuery)->take(5)->get();
            $data['student'] = $student;
            return $data;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
