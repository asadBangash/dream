<?php

namespace App\Http\Requests\StudentInfo\Student;

use Illuminate\Foundation\Http\FormRequest;

class StudentUpdateRequest extends FormRequest
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
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $mobile = '';
        if (Request()->mobile != '') {
            $mobile = 'max:255|unique:users,phone,' . $this->user_id;
        }

        $email = '';
        if (Request()->email != '') {
            $email = 'max:255|unique:users,email,' . $this->user_id;
        }

        return [
            'mobile'         => $mobile,
            'email'          => $email,
            'admission_no'   => 'required|max:255|unique:students,admission_no,' . $this->id,
            'roll_no'        => 'required|max:255',
            'first_name'     => 'required|max:255',
            'last_name'      => 'required|max:255',
            'department_id'   => 'required|exists:departments,id',
            'class'          => 'required|max:255',
            'section'        => 'required|max:255',
            'date_of_birth'  => 'required|max:255',
            'admission_date' => 'required|max:255',
            'parent'         => 'required|max:255',
            'status'         => 'required|max:255',
            'username'       => 'unique:users,username,' . $this->user_id . ',id',
        ];
    }
}
