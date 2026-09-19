<?php

namespace App\Repositories\ParentPanel;

use App\Interfaces\ParentPanel\ClassRoutineInterface;
use App\Traits\ReturnFormatTrait;
use App\Models\StudentInfo\SessionClassStudent;
use Illuminate\Http\Request;
use App\Models\Academic\ClassRoutine;
use App\Models\Academic\ClassRoutineChildren;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentInfo\ParentGuardian;
use App\Models\StudentInfo\Student;
use Illuminate\Support\Facades\Session;

class ClassRoutineRepository implements ClassRoutineInterface
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
            $request = new Request([
                'class'   => @$classSection->classes_id,
                'section' => @$classSection->section_id,
            ]);

            $data['result'] = ClassRoutine::where('classes_id', $request->class)->where('section_id', $request->section)->where('session_id', setting('session'))->orderBy('day')->get();
            $data['time']   = ClassRoutineChildren::whereHas('classRoutine', function($q) use($request){
                $q->where('classes_id', $request->class)->where('section_id', $request->section)->where('session_id', setting('session'));
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
