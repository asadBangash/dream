<?php

namespace App\Http\Requests\Academic\Shift;

use App\Rules\BranchUnique;
use Illuminate\Foundation\Http\FormRequest;

class ShiftStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return array_merge([
            'name' => ['required', 'max:255', new BranchUnique('shifts', 'name')],
            'status' => ['required'],
        ], branchIdValidationRules());
    }
}
