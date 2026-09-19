<?php

namespace App\Http\Requests\StudentInfo\OnlineAdmission;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class OnlineAdmissionFeesAssignRequest extends FormRequest
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
            'fees_group' => [
                'required'
            ],
            'class' => [
                'required'
            ],
            'section' => [
                'required'

            ],
            'session_id' => [
                'required'
            ],
        ];
    }
}
