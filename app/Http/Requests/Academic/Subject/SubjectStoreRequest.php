<?php

namespace App\Http\Requests\Academic\Subject;

use App\Rules\BranchUnique;
use Illuminate\Foundation\Http\FormRequest;

class SubjectStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return array_merge([
            'name' => [
                'required',
                new BranchUnique('subjects', 'name', null, null, ['type' => $this->input('type')]),
            ],
            'type' => ['required'],
            'status' => ['required', 'max:10'],
            'code' => ['required', 'max:50'],
        ], branchIdValidationRules());
    }

    public function messages()
    {
        return [
            'name.unique' => 'The combination of name and type must be unique within this branch.',
        ];
    }
}
