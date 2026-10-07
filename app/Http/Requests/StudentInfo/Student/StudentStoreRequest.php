<?php

namespace App\Http\Requests\StudentInfo\Student;

use App\Rules\BranchUnique;
use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $mobile = '';
        if (Request()->mobile != '') {
            $mobile = 'max:255|unique:users,phone';
        }

        $email = '';
        if (Request()->email != '') {
            $email = 'max:255|unique:users,email';
        }

        return array_merge([
            'mobile' => $mobile,
            'email' => $email,
            'admission_no' => ['required', 'max:255', new BranchUnique('students', 'admission_no')],
            'roll_no' => 'required|max:255',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'department_id' => 'required|exists:departments,id',
            'health_status' => 'nullable|max:255',
            'rank_in_family' => 'nullable|max:20',
            'siblings' => 'nullable|max:20',
            'class' => 'required|max:255',
            'section' => 'required|max:255',
            'date_of_birth' => 'required|max:255',
            'admission_date' => 'required|max:255',
            'parent' => 'required|max:255',
            'status' => 'required|max:255',
            'siblings_discount' => 'nullable',
            'username' => 'unique:users,username',
            'password' => 'min:6',
        ], branchIdValidationRules());
    }
}
