<?php

namespace App\Http\Requests\StudentInfo\Student;

use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
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
     * array:21 [▼ // app\Http\Controllers\StudentInfo\StudentController.php:79
     *
     * @return array<string, mixed>
     */
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

        return [
            'mobile' => $mobile,
            'email' => $email,
            'admission_no' => 'required|max:255|unique:students,admission_no',
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
            'password' => 'min:6'
        ];
    }
}
