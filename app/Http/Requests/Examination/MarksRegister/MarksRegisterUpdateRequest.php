<?php

namespace App\Http\Requests\Examination\MarksRegister;

use Illuminate\Foundation\Http\FormRequest;

class MarksRegisterUpdateRequest extends FormRequest
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
        return [
            'class'              => 'required|max:10',
            'section'            => 'required|max:10',
            'exam_type'          => 'required|max:10',
            'subject'            => "required|max:10",
            'student_ids'        => "required",
            'marks'              => "required",
        ];
    }
}
