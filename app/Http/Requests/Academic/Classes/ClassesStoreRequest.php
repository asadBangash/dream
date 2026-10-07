<?php

namespace App\Http\Requests\Academic\Classes;

use App\Rules\BranchUnique;
use Illuminate\Foundation\Http\FormRequest;

class ClassesStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return array_merge([
            'name' => ['required', 'max:255', new BranchUnique('classes', 'name')],
            'status' => ['required'],
        ], branchIdValidationRules());
    }
}
