<?php

namespace App\Http\Requests\OnlineExamination\OnlineExam;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $question = '';
        $student = '';
        if(!isset($_POST['questions_ids']))
            $question = 'required';
        if(!isset($_POST['student_ids']))
            $student = 'required';

        return [
            'name'           => 'required',
            'mark'           => 'required',
            'start'          => 'required',
            'end'            => 'required',
            'published'      => 'required',
            'question_group' => 'required',
            'class'          => 'required',
            'section'        => 'required',
            'questions_ids'  => $question,
            'student_ids'    => $student
        ];
    }
}
