<?php

namespace App\Repositories\StudentPanel\Homework;

use App\Models\Homework;
use App\Models\HomeworkStudent;
use App\Traits\CommonHelperTrait;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\Auth;
use App\Repositories\StudentPanel\Homework\HomeworkInterface;

class HomeworkRepository implements HomeworkInterface
{
    use ReturnFormatTrait, CommonHelperTrait;

    private $model;

    function __construct(Homework $model)
    { 
        $this->model = $model;
    }

    public function index()
    {
        return $this->model::where('classes_id', Auth::user()->student?->session_class_student?->classes_id)
                        ->where('section_id', Auth::user()->student?->session_class_student?->section_id)
                        ->orderBy('id', 'DESC')
                        ->paginate(10);

    }

    public function submit($request)
    {
        try {

            if(!$homework_student = HomeworkStudent::where('student_id', Auth::user()->student->id)->where('homework_id', $request->homework_id)->first()) {

                $homework_student              = new HomeworkStudent();
                $homework_student->homework    = ''; 
            }


            $homework_student->student_id  = Auth::user()->student->id;
            $homework_student->homework_id = $request->homework_id;
            $homework_student->date        = date('Y-m-d');
            $homework_student->homework    = $this->UploadImageUpdate($request->homework, 'backend/uploads/homeworks', $homework_student->homework);
            $homework_student->save();

            return $this->responseWithSuccess(___('alert.created_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }

    }
}
