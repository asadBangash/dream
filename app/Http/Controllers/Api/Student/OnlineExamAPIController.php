<?php

namespace App\Http\Controllers\Api\Student;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use App\Models\StudentInfo\Student;
use App\Http\Controllers\Controller;
use App\Models\Examination\ExamType;
use App\Models\OnlineExamination\Answer;
use App\Models\OnlineExamination\OnlineExam;
use App\Http\Resources\Student\ExamTypeResource;
use App\Models\OnlineExamination\AnswerChildren;
use App\Http\Resources\Student\OnlineExamResource;
use App\Http\Resources\Student\OnlineExamQuestionResource;
use App\Models\OnlineExamination\OnlineExamChildrenQuestions;

class OnlineExamAPIController extends Controller
{
    use ReturnFormatTrait;


    public function index()
    {
        try {

            if (!sessionClassStudent()) {
                return $this->responseWithError(___('alert.Student not found'));
            }

            $sessionClassStudent    = sessionClassStudent();

            $examType               = ExamType::active()
                                    ->whereHas('onlineExams', function ($q) use ($sessionClassStudent) {
                                        $q->where('session_id', $sessionClassStudent->session_id)
                                        ->where('classes_id', $sessionClassStudent->classes_id)
                                        ->where('section_id', $sessionClassStudent->section_id);
                                    })
                                    ->first();

            $exam_type_id           = request()->filled('exam_type_id') ? request('exam_type_id') : @$examType->id;

            $onlineExams            = OnlineExam::active()
                                    ->where('exam_type_id', $exam_type_id)
                                    ->where('session_id', $sessionClassStudent->session_id)
                                    ->where('classes_id', $sessionClassStudent->classes_id)
                                    ->where('section_id', $sessionClassStudent->section_id)
                                    ->where('published', '<=', now())
                                    ->with('answer')
                                    ->get();

            $data                   = OnlineExamResource::collection($onlineExams);

            return $this->responseWithSuccess(___('alert.success'), $data);

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), $th->getMessage());
        }
    }


    public function onlineExamQuestions($online_exam_id)
    {
        try {

            if (!sessionClassStudent()) {
                return $this->responseWithError(___('alert.Student not found'));
            }

            $request = request();
            $request->request->add(['is_question' => true]);

            $sessionClassStudent    = sessionClassStudent();

            $onlineExam             = OnlineExam::active()
                                    ->where('id', $online_exam_id)
                                    ->where('session_id', $sessionClassStudent->session_id)
                                    ->where('classes_id', $sessionClassStudent->classes_id)
                                    ->where('section_id', $sessionClassStudent->section_id)
                                    ->where('published', '<=', now())
                                    ->with('examQuestions');

            $examInfo               = OnlineExamResource::collection($onlineExam->take(1)->get());

            $data['exam_info']      = @$examInfo[0];
            $data['questions']      = OnlineExamQuestionResource::collection($onlineExam->first()?->examQuestions ?? []);

            return $this->responseWithSuccess(___('alert.success'), $data);

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), $th->getMessage());
        }
    }


    public function store(Request $request, $online_exam_id)
    {
        try {

            if (!sessionClassStudent()) {
                return $this->responseWithError(___('alert.Student not found'));
            }

            $student_id         = @sessionClassStudent()->student_id;
            $isParticipant      = Answer::where([
                                    'online_exam_id' => $online_exam_id,
                                    'student_id'     => $student_id
                                ])
                                ->first();

            if ($isParticipant) {
                return $this->responseWithError(___('alert.already_participant'), []);
            }

            DB::transaction(function () use ($request, $online_exam_id, $student_id) {
                $answer = Answer::create([
                    'online_exam_id' => $online_exam_id,
                    'student_id'     => $student_id
                ]);

                foreach ($request->data ?? [] as $value) {
                    $question_bank_id       = OnlineExamChildrenQuestions::where('id', $value['question_ids'])->first()?->question_bank_id;

                    if ($question_bank_id) {
                        AnswerChildren::create([
                            'answer_id'         => $answer->id,
                            'question_bank_id'  => $question_bank_id,
                            'answer'            => $value['answers']
                        ]);
                    }
                }
            });

            return $this->responseWithSuccess(___('alert.submitted_successfully'), []);

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), $th->getMessage());
        }
    }


    public function result($online_exam_id)
    {
        try {

            if (!sessionClassStudent()) {
                return $this->responseWithError(___('alert.Student not found'));
            }

            $request = request();
            $request->request->add(['is_result' => true]);

            $sessionClassStudent    = sessionClassStudent();

            $onlineExam             = OnlineExam::active()
                                    ->where('id', $online_exam_id)
                                    ->where('session_id', $sessionClassStudent->session_id)
                                    ->where('classes_id', $sessionClassStudent->classes_id)
                                    ->where('section_id', $sessionClassStudent->section_id)
                                    ->where('published', '<=', now())
                                    ->with('examQuestions');

            $examInfo               = OnlineExamResource::collection($onlineExam->take(1)->get());

            $data['exam_info']      = @$examInfo[0];
            $data['questions']      = OnlineExamQuestionResource::collection(@$onlineExam->first()->examQuestions ?? []);

            return $this->responseWithSuccess(___('alert.success'), $data);

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), $th->getMessage());
        }
    }


    public function onlineExamTypes()
    {
        try {

            if (!sessionClassStudent()) {
                return $this->responseWithError(___('alert.Student not found'));
            }

            $sessionClassStudent    = sessionClassStudent();

            $examTypes              = ExamType::active()
                                        ->whereHas('onlineExams', function ($q) use ($sessionClassStudent) {
                                            $q->where('session_id', $sessionClassStudent->session_id)
                                            ->where('classes_id', $sessionClassStudent->classes_id)
                                            ->where('section_id', $sessionClassStudent->section_id);
                                        })
                                    ->get();


            $data                   = ExamTypeResource::collection($examTypes);

            return $this->responseWithSuccess(___('alert.success'), $data);

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), $th->getMessage());
        }
    }
}
