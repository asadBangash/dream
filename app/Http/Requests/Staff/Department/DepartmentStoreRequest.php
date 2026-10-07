<?php

namespace App\Http\Requests\Staff\Department;

use App\Rules\BranchUnique;
use Illuminate\Foundation\Http\FormRequest;

class DepartmentStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return array_merge([
            'name' => ['required', new BranchUnique('departments', 'name')],
            'status' => ['required'],
            'staff_user_id' => ['nullable'],
        ], branchIdValidationRules());
    }
}
