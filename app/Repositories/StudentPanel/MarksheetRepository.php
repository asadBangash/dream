<?php

namespace App\Repositories\StudentPanel;

use App\Interfaces\StudentPanel\MarksheetInterface;
use App\Models\Examination\MarksGrade;
use App\Models\StudentInfo\SessionClassStudent;
use App\Models\StudentInfo\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Examination\MarksRegister;

class MarksheetRepository implements MarksheetInterface
{
    public function index()
    {
        $student = Student::where('user_id', Auth::user()->id)->first();
        $classSection = SessionClassStudent::where('session_id', setting('session'))->where('student_id', $student->id)->latest()->first();

        $request = new Request([
            'class' => @$classSection->classes_id,
            'section' => @$classSection->section_id,
        ]);
        return $request;
    }

    public function search($request)
    {
        try {
            $student = Student::where('user_id', Auth::user()->id)->first();
            $classSection = SessionClassStudent::where('session_id', setting('session'))->where('student_id', $student->id)->latest()->first();

            $request = new Request([
                'exam_type' => $request->exam_type,
                'class' => @$classSection->classes_id,
                'section' => @$classSection->section_id,
            ]);

            $marks_registers = MarksRegister::where('exam_type_id', $request->exam_type)
                ->where('classes_id', $request->class)
                ->where('section_id', $request->section)
                ->where('session_id', setting('session'))
                ->with('marksRegisterChilds', function ($query) use ($student) {
                    $query->where('student_id', $student->id);
                })
                ->get();


            $result = ___('examination.Passed');
            $total_marks = 0;
            foreach ($marks_registers as $marks_register) {
                $total_marks += $marks_register->marksRegisterChilds->sum('mark');
                if ($marks_register->marksRegisterChilds->sum('mark') < examSetting('average_pass_marks')) {
                    $result = ___('examination.Failed');
                }
            }

            $grades = MarksGrade::where('session_id', setting('session'))->get();
            $gpa = '';
            foreach ($grades as $grade) {
                if ($grade->percent_from <= $total_marks / count($marks_registers) && $grade->percent_upto >= $total_marks / count($marks_registers)) {
                    $gpa = $grade->point;
                }
            }

            $data = [];
            $data['marks_registers'] = $marks_registers;
            $data['result'] = $result;
            $data['gpa'] = $gpa;
            $data['avg_marks'] = $total_marks / count($marks_registers);

            $data['student'] = $student;

            return $data;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
