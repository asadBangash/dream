<?php

namespace App\Http\Requests\Academic\Section;

use App\Rules\BranchUnique;
use Illuminate\Foundation\Http\FormRequest;

class SectionStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return array_merge([
            'name' => ['required', 'max:255', new BranchUnique('sections', 'name')],
            'status' => ['required'],
        ], branchIdValidationRules());
    }
}
