<?php

namespace App\Http\Requests\Examination\Type;

use App\Rules\BranchUnique;
use Illuminate\Foundation\Http\FormRequest;

class ExamTypeStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return array_merge([
            'name' => ['required', 'max:255', new BranchUnique('exam_types', 'name')],
        ], branchIdValidationRules());
    }
}
