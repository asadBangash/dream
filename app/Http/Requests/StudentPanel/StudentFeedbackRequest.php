<?php

namespace App\Http\Requests\StudentPanel;

use Illuminate\Foundation\Http\FormRequest;

class StudentFeedbackRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "type"             => ["required", "in:pickup,drop"],
            "duty_schedule_id" => ["required", "exists:drive_duty_schedules,id"],
            "student_feedback" => ["required", "string"]
        ];
    }
}
