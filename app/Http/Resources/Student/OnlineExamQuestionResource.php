<?php

namespace App\Http\Resources\Student;

use App\Models\OnlineExamination\AnswerChildren;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\OnlineExamination\QuestionBankChildren;

class OnlineExamQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $questionType           = Str::slug($this->questionType(@$this->question->type));
        $options                = [];
        $totalOptions           = 0;

        if ($questionType == 'single-choice' || $questionType == 'multiple-choice') {
            $options            = QuestionBankChildren::where('question_bank_id', $this->question_bank_id)->get(['id', 'option']);
            $totalOptions       = @$this->question->total_option;
        } elseif ($questionType == 'true-false') {
            $options            = [
                                    ['id' => 1, 'option' => 'True'],
                                    ['id' => 2, 'option' => 'False'],
                                ];
            $totalOptions       = 2;
        }
        $answer = @$this->question->answer ?? [];
        $data = [
            'id'                => $this->id,
            'question'          => @$this->question->question,
            'question_type'     => $questionType,
            'total_option'      => $totalOptions,
            'options'           => $options,
            'answer'            => (gettype($answer) == 'array') ? $answer : [$answer],
            'mark'              => @$this->question->mark
        ];

        if (request('is_result')) {
            $givenAnswer        = AnswerChildren::query()
                                ->where('question_bank_id', $this->question_bank_id)
                                ->whereHas('answer', fn ($q) => $q->where('online_exam_id', $this->online_exam_id))
                                ->first();

            $data['given_answer']       = @$givenAnswer->answer;
            $data['evaluation_mark']    = @$givenAnswer->evaluation_mark;
        }

        return $data;
    }

    protected function questionType($key)
    {
        $questionTypes = Config::get('site.question_types');

        if (array_key_exists($key, $questionTypes)) {
            return ___($questionTypes[$key]);
        } else {
            return null;
        }
    }
}
