<?php

namespace App\Repositories\ParentPanel;

use App\Interfaces\ParentPanel\SubjectListInterface;
use App\Models\StudentInfo\SessionClassStudent;
use App\Models\Academic\SubjectAssign;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentInfo\ParentGuardian;
use App\Models\StudentInfo\Student;

class SubjectListRepository implements SubjectListInterface
{
    public function index()
    {
        try {
            $parent           = ParentGuardian::where('user_id', Auth::user()->id)->first();
            $data['students'] = Student::where('parent_guardian_id', $parent->id)->get();
            $data['student']  = Student::where('id', Session::get('student_id'))->first();

            return $data;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function search($request)
    {
        try {
            Session::put('student_id', $request->student);
            $parent   = ParentGuardian::where('user_id', Auth::user()->id)->first();
            $data['students'] = Student::where('parent_guardian_id', $parent->id)->get();
            $data['student']  = Student::where('id', Session::get('student_id'))->first();

            $classSection   = SessionClassStudent::where('session_id', setting('session'))->where('student_id', Session::get('student_id'))->latest()->first();
            $data['subjectTeacher'] = SubjectAssign::where('session_id', setting('session'))->where('classes_id', @$classSection->classes_id)->where('section_id', @$classSection->section_id)->first();
        
            return $data;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
