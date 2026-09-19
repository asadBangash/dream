<?php

namespace App\Http\Controllers\Api\Teacher;

use Illuminate\Http\Request;
use App\Traits\ReturnFormatTrait;
use App\Http\Controllers\Controller;
use App\Models\Examination\ExamType;
use App\Models\OnlineExamination\OnlineExam;
use App\Http\Resources\Student\ExamTypeResource;
use App\Http\Resources\OnlineExamStudentResource;
use App\Http\Resources\TeacherOnlineExamResource;
use App\Http\Resources\Student\OnlineExamResource;
use App\Http\Resources\OnlineExamStudentResultResource;
use App\Interfaces\OnlineExamination\OnlineExamInterface;
use App\Http\Resources\Student\OnlineExamQuestionResource;

class TeacherOnlineExamController extends Controller
{
     use ReturnFormatTrait;


     public function types(){

        return $this->responseWithSuccess(___('alert.success'), [
             ExamTypeResource::collection(ExamType::active()->get())
        ]);
     }


    public function list()
    {

         request()->merge(array_map(function ($value) {
                    return $value === 'null' ? null : $value;
                }, request()->all()));


            $online_exams = OnlineExam::where(function ($query) {
                $query->whereIn('subject_id', teacherSubjects())
                    ->orWhereNull('subject_id');
            })
            ->when(request('class_id'), fn($q) => $q->where('classes_id', request('class_id')))
            ->when(request('section_id'), fn($q) => $q->where('section_id', request('section_id')))
            ->when(request('subject_id'), fn($q) => $q->where('subject_id', request('subject_id')))
            ->with(['class:id,name', 'subject:id,name', 'section:id,name', 'type:id,name'])
            ->latest()
            ->active()
            ->paginate(10);



            return $this->responseWithSuccess(___('alert.success'), [
                'data' => TeacherOnlineExamResource::collection($online_exams ?? collect()),
                'meta' => [
                    'current_page' => $online_exams->currentPage(),
                    'last_page' => $online_exams->lastPage(),
                    'per_page' => $online_exams->perPage(),
                    'total' => $online_exams->total(),
                ]
            ]);
         return $this->responseWithSuccess('Online Exams List', $data);
    }

    public function questions($id)
    {

        $onlineExam = OnlineExam::with(['questions.questionOptions'])->where('id', $id)->first();
        if(!$onlineExam){
            return $this->responseWithError(___('alert.online_exam_not_found'));
        }

        $data['exam_info']      = new TeacherOnlineExamResource($onlineExam);
        $data['questions']      = OnlineExamQuestionResource::collection($onlineExam->examQuestions ?? []);

        return $this->responseWithSuccess(___('alert.success'), $data);

    }


    public function results($online_exam_id)
    {
        try {
            $onlineExam             = OnlineExam::with(['examStudents:id,student_id,online_exam_id','studentAnswer','examStudents.student'])->find($online_exam_id);
            $data['exam_info']      = new TeacherOnlineExamResource($onlineExam);
            $data['exam_results']      = new OnlineExamStudentResultResource($onlineExam);
            return $data;

            return $this->responseWithSuccess(___('alert.success'), $data);

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), $th->getMessage());
        }
    }
}
