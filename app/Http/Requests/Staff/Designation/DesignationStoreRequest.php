<?php

namespace App\Http\Requests\Staff\Designation;

use App\Rules\BranchUnique;
use Illuminate\Foundation\Http\FormRequest;

class DesignationStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return array_merge([
            'name' => ['required', 'max:255', new BranchUnique('designations', 'name')],
            'status' => ['required'],
        ], branchIdValidationRules());
    }
}
