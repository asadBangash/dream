<?php

namespace App\Http\Requests\StudentInfo\OnlineAdmission;

use Illuminate\Foundation\Http\FormRequest;

class OnlineAdmissionRequest extends FormRequest
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
            $mobile = 'max:255|unique:users,phone';
        }

        $email = '';
        if (Request()->email != '') {
            $email = 'max:255|unique:users,email';
        }

        return [
            // student information
            'mobile'                    => $mobile,
            'email'                     => $email,
            'admission_no'              => 'required|max:255|unique:students,admission_no',
            'roll_no'                   => 'required|max:255',
            'first_name'                => 'required|max:255',
            'last_name'                 => 'required|max:255',
            'class'                     => 'required|max:255',
            'section'                   => 'required|max:255',
            'date_of_birth'             => 'required|max:255',
            'admission_date'            => 'required|max:255',
            'status'                    => 'required|max:255',
            
            // parent information
            'guardian_mobile'        => 'required|max:255|unique:users,phone',
            'guardian_name'          => 'required|max:255',
            'status'                 => 'required|max:255',
            'father_name'            => 'max:255',
            'father_mobile'          => 'max:255',
            'father_profession'      => 'max:255',
            'mother_name'            => 'max:255',
            'mother_mobile'          => 'max:255',
            'mother_profession'      => 'max:255',
            'guardian_profession'    => 'max:255',
            'guardian_email'         => 'max:255',
            'guardian_address'       => 'max:255',
            'guardian_relation'      => 'max:255'
        ];
       
           
    }
}
