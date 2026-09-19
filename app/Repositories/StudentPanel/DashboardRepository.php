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
            $student = Student::where('user_id', Auth::user()->id)->first();
            $classSection   = SessionClassStudent::where('session_id', setting('session'))
                            ->where('student_id', @$student->id)
                            ->first();
            
            $subjectTeacher = SubjectAssign::where('session_id', setting('session'))
                            ->where('classes_id', @$classSection->classes_id)
                            ->where('section_id', @$classSection->section_id)
                            ->first();
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
            $data['totalEvent']     = Event::where('session_id', setting('session'))
                            ->active()->where('date', '>=', date('Y-m-d'))
                            ->orderBy('date')
                            ->count();
            $data['events']         = Event::where('session_id', setting('session'))
                            ->active()->where('date', '>=', date('Y-m-d'))
                            ->orderBy('date')
                            ->take(5)
                            ->get();
            $data['student'] = $student;
            return $data;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
