<?php

namespace App\Http\Requests\Academic\Subject;

use Illuminate\Foundation\Http\FormRequest;

class SubjectUpdateRequest extends FormRequest
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
            'name' => 'required|unique:subjects,name,'.$this->id.',id,type,'.$this->type,
            'type' => 'required',
            'type'   => 'required|max:10',
            'status' => 'required|max:10'
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'The combination of name and type must be unique.',
        ];
    }
}
