<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Request;
use App\Models\OnlineExamination\QuestionBank;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherOnlineExamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $startDate              = new DateTime($this->start);
        $endDate                = new DateTime($this->end);
        $interval               = date_diff($startDate, $endDate);

        $totalMark              = QuestionBank::whereIn('id', $this->examQuestions->pluck('question_bank_id')->toArray())->sum('mark');

        $passPercentage         = examSetting('average_pass_marks');
        $passMark               = ($this->total_mark * $passPercentage) / 100;

        $totalQuestion = @$this->examQuestions->count() ?? 0;
        $subjectName   = @$this->subject->name;
        $duration      = $interval->format('%d Day %h Hour %i Minute');
        $totalMark     = (int) $totalMark;

        $data = [
            'id'             => $this->id,
            'name'           => $this->name,
            'class_sec'      => @$this->class->name . '-' . @$this->section->name,
            'exam_type'      => @$this->type->name,
            'subject_name'   => $subjectName,
            'total_question' => $totalQuestion,
            'duration'       => $duration,
            'start_time'     => $this->start,
            'end_time'       => $this->end,
            'total_mark'     => $totalMark,
        ];

        // Add optional score/result status only if not a question request
        if (!request('is_question')) {
            $resultStatus = 'Pending';

            if (@$this->answer && @$this->answer->result >= $passMark) {
                $resultStatus = 'Pass';
            } elseif (@$this->answer && @$this->answer->result < $passMark) {
                $resultStatus = 'Fail';
            }

           
        }

        return $data;
    }



}
