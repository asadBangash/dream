<?php

namespace App\Http\Requests\OnlineExamination\QuestionBank;

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
        $single_choice_ans   = '';
        $multiple_choice_ans = '';
        $true_false_ans      = '';
        $total_option        = '';
        $option              = '';
        if($this->type == 1){
            $single_choice_ans = 'required';
            $total_option      = 'required';
            $option            = 'required';
        }
        elseif($this->type == 2){
            $multiple_choice_ans = 'required';
            $total_option        = 'required';
            $option              = 'required';
        }
        if($this->type == 3)
            $true_false_ans = 'required';

        return [
            'question_group'      => 'required',
            'type'                => 'required',
            'question'            => 'required',
            'mark'                => 'required',
            'status'              => 'required',
            'single_choice_ans'   => $single_choice_ans,
            'multiple_choice_ans' => $multiple_choice_ans,
            'true_false_ans'      => $true_false_ans,
            'total_option'        => $total_option,
            'option.*'            => $option,
        ];
    }
}
