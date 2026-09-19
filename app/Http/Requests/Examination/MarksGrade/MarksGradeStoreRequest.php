<?php

namespace App\Http\Requests\Examination\MarksGrade;

use Illuminate\Foundation\Http\FormRequest;

class MarksGradeStoreRequest extends FormRequest
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
            'name'              => 'required|max:255',
            'point'             => 'required|max:255',
            'percent_from'      => 'required|max:255',
            'percent_upto'      => "required|max:255|gte:percent_from",
        ];
    }
}
