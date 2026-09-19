<?php

namespace App\Repositories\StudentPanel;

use App\Interfaces\StudentPanel\ExamRoutineInterface;
use App\Models\StudentInfo\SessionClassStudent;
use App\Models\StudentInfo\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Academic\ExamRoutine;
use App\Models\Academic\ExamRoutineChildren;

class ExamRoutineRepository implements ExamRoutineInterface
{
    public function index(){
        $student        = Student::where('user_id', Auth::user()->id)->first();
        $classSection   = SessionClassStudent::where('session_id', setting('session'))->where('student_id', $student->id)->latest()->first();
        
        $request = new Request([
            'class'   => @$classSection->classes_id,
            'section' => @$classSection->section_id,
        ]);
        return $request;
    }
    
    public function search($request)
    {
        try {
            $student        = Student::where('user_id', Auth::user()->id)->first();
            $classSection   = SessionClassStudent::where('session_id', setting('session'))->where('student_id', $student->id)->latest()->first();
            
            $request = new Request([
                'class'   => @$classSection->classes_id,
                'section' => @$classSection->section_id,
                'type'    => $request->exam_type,
            ]);

            $data['result']       = ExamRoutine::where('classes_id', $request->class)->where('section_id', $request->section)->where('type_id', $request->type)->where('session_id', setting('session'))->orderBy('date')->get();

            $data['time']         = ExamRoutineChildren::whereHas('examRoutine', function($q) use($request){
                $q->where('classes_id', $request->class)->where('section_id', $request->section)->where('type_id', $request->type)->where('session_id', setting('session'));
            })
            ->orderBy('time_schedule_id')
            ->select('time_schedule_id')
            ->distinct()
            ->get();

            return $data;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
