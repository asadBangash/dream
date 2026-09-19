<?php

namespace App\Http\Requests\Academic\ExamRoutine;

use Illuminate\Foundation\Http\FormRequest;

class ExamRoutineUpdateRequest extends FormRequest
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
        // dd($this->all());
        return [
            'class'         => 'required',
            'section'       => 'required',
            'type'         => 'required',
            'date'          => 'required',
        ];
    }
}