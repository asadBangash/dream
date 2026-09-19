<?php

namespace App\Repositories\ParentPanel;

use App\Interfaces\ParentPanel\MarksheetInterface;
use App\Models\Examination\MarksGrade;
use App\Models\StudentInfo\SessionClassStudent;
use App\Models\StudentInfo\Student;
use Illuminate\Http\Request;
use App\Models\Examination\MarksRegister;
use Illuminate\Support\Facades\Session;
use App\Models\StudentInfo\ParentGuardian;
use Illuminate\Support\Facades\Auth;

class MarksheetRepository implements MarksheetInterface
{
    public function studentInfo($id) // student id
    {
        try {

            $classSection   = SessionClassStudent::where('session_id', setting('session'))->where('student_id', $id)->latest()->first();
            $request = new Request([
                'class'   => @$classSection->classes_id,
                'section' => @$classSection->section_id,
            ]);
            return $request;

        } catch (\Throwable $th) {
            return false;
        }
    }
    
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
            $data = [];

            Session::put('student_id', $request->student);
            $parent   = ParentGuardian::where('user_id', Auth::user()->id)->first();
            $data['students'] = Student::where('parent_guardian_id', $parent->id)->get();

            $student        = Student::where('id', Session::get('student_id'))->first();
            $classSection   = SessionClassStudent::where('session_id', setting('session'))->where('student_id', @$student->id)->latest()->first();
            
            $request = new Request([
                'exam_type'   => $request->exam_type,
                'class'       => @$classSection->classes_id,
                'section'     => @$classSection->section_id,
            ]);

            $marks_registers = MarksRegister::where('exam_type_id', $request->exam_type)
            ->where('classes_id', $request->class)
            ->where('section_id', $request->section)
            ->where('session_id', setting('session'))
            ->with('marksRegisterChilds', function ($query) use($student) {
                $query->where('student_id', $student->id);
            })
            ->get();


            $result      = ___('examination.Passed');
            $total_marks = 0;
            foreach($marks_registers as $marks_register) {
                $total_marks += $marks_register->marksRegisterChilds->sum('mark');
                if($marks_register->marksRegisterChilds->sum('mark') < examSetting('average_pass_marks')) {
                    $result = ___('examination.Failed');
                }
            }

            $grades = MarksGrade::where('session_id', setting('session'))->get();
            $gpa = '';
            foreach($grades as $grade) {
                    if($grade->percent_from <= $total_marks/count($marks_registers) && $grade->percent_upto >= $total_marks/count($marks_registers)) {
                        $gpa = $grade->point;
                    }
            }

            $data['marks_registers'] = $marks_registers;
            $data['result']          = $result;
            $data['gpa']             = $gpa;
            $data['avg_marks']       = $total_marks/count($marks_registers);

            $data['student']         = $student;

            return $data;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
