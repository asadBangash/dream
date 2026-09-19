<?php

namespace App\Http\Requests\StudentInfo\PromoteStudent;

use Illuminate\Foundation\Http\FormRequest;

class PromoteStudentSearchRequest extends FormRequest
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
            'class'           => 'required',
            'section'         => 'required',
            'promote_session' => 'required',
            'promote_class'   => 'required',
            'promote_section' => 'required',
        ];
    }
}
