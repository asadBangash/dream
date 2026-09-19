<?php

namespace App\Repositories\ParentPanel;

use App\Models\Event;
use App\Models\StudentInfo\Student;
use Illuminate\Support\Facades\Auth;
use App\Models\Academic\ClassRoutine;
use App\Models\Academic\SubjectAssign;
use Illuminate\Support\Facades\Session;
use App\Models\StudentInfo\ParentGuardian;
use App\Models\Academic\SubjectAssignChildren;
use App\Models\StudentInfo\SessionClassStudent;
use App\Interfaces\ParentPanel\DashboardInterface;

class DashboardRepository implements DashboardInterface
{
    public function index()
    {
        try {
            $parent           = ParentGuardian::where('user_id', Auth::user()->id)->first();
            $data['students'] = Student::where('parent_guardian_id', $parent->id)->get();
            if(Session::get('student_id'))
                $student        = Student::where('id', Session::get('student_id'))->first();
            else
                $student        = Student::where('parent_guardian_id', $parent->id)->latest()->first();

            Session::put('student_id', @$student->id);

            if($student){
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
            }
            $data['student'] = $student;
            return $data;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function search($request)
    {
        try {
            Session::put('student_id', $request->student);

            $parent           = ParentGuardian::where('user_id', Auth::user()->id)->first();
            $data['students'] = Student::where('parent_guardian_id', $parent->id)->get();
            $student          = Student::where('id', Session::get('student_id'))->first();

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
