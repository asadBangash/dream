<?php

namespace App\Repositories\ParentPanel\Homework;

use App\Models\Homework;
use App\Models\HomeworkStudent;
use App\Traits\CommonHelperTrait;
use App\Traits\ReturnFormatTrait;
use App\Models\StudentInfo\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\StudentInfo\ParentGuardian;
use App\Models\StudentInfo\SessionClassStudent;
use App\Repositories\ParentPanel\Homework\HomeworkInterface;

class HomeworkRepository implements HomeworkInterface
{
    use ReturnFormatTrait, CommonHelperTrait;

    private $model;

    function __construct(Homework $model)
    { 
        $this->model = $model;
    }

    public function index($request)
    {
        $classSection   = SessionClassStudent::where('session_id', setting('session'))->where('student_id', $request->student)->latest()->first();
        return $this->model::where('classes_id', $classSection->classes_id)
                        ->where('section_id', $classSection->section_id)
                        ->orderBy('id', 'DESC')
                        ->paginate(10);
    }

    public function indexParent()
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

            $student        = Student::where('id', Session::get('student_id'))->first();
            $classSection   = SessionClassStudent::where('session_id', setting('session'))->where('student_id', $student->id)->latest()->first();

            $result = Homework::query();
            $result = $result->where('session_id', setting('session'))
            ->where('classes_id', $classSection->classes_id)
            ->where('section_id', $classSection->section_id);            
            if($request->view == 0) {
                $data['homeworks'] = $result->get();
            }
            else{
                $data['homeworks'] = $result->paginate(10);
            }

            return $data;

        } catch (\Throwable $th) {
            return false;
        }
    }

}
