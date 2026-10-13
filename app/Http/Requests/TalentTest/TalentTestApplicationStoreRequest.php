<?php

namespace App\Http\Requests\TalentTest;

use Illuminate\Foundation\Http\FormRequest;

class TalentTestApplicationStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|in:1,2',
            'contact_number' => 'required|string|max:20',
            'guardian_contact' => 'nullable|string|max:20',
            'home_address' => 'required|string|max:500',
            'current_class' => 'required|string|max:100',
            'school_name' => 'required|string|max:255',
            'last_exam_marks' => 'required|string|max:50',
            'total_marks' => 'required|string|max:50',
        ];
    }
}
