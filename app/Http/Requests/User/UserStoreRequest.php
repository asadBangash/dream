<?php

namespace App\Http\Requests\User;

use App\Rules\BranchUnique;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return array_merge([
            'staff_id' => ['required', new BranchUnique('staff', 'staff_id')],
            'role' => 'required',
            'designation' => 'required',
            'department' => 'required',
            'first_name' => 'required|max:25',
            'email' => 'required|unique:users,email',
            'gender' => 'required',
            'dob' => 'required',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|max:11',
            'status' => 'required',
            'image' => 'max:2048',
        ], branchIdValidationRules());
    }
}
