<?php

namespace App\Repositories\StudentPanel;

use App\Interfaces\StudentPanel\SubjectListInterface;
use App\Traits\ReturnFormatTrait;
use App\Models\StudentInfo\SessionClassStudent;
use App\Models\StudentInfo\Student;
use Illuminate\Support\Facades\Auth;
use App\Models\Academic\SubjectAssign;

class SubjectListRepository implements SubjectListInterface
{
    public function index()
    {
        try {
            $student        = Student::where('user_id', Auth::user()->id)->first();
            $classSection   = SessionClassStudent::where('session_id', setting('session'))->where('student_id', $student->id)->latest()->first();
            $subjectTeacher = SubjectAssign::where('session_id', setting('session'))->where('classes_id', $classSection->classes_id)->where('section_id', $classSection->section_id)->first();

            return $subjectTeacher;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
