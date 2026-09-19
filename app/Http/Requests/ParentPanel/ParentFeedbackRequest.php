<?php

namespace App\Http\Requests\ParentPanel;

use Illuminate\Foundation\Http\FormRequest;

class ParentFeedbackRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "type"              => ["required", "in:pickup,drop"],
            "duty_schedule_id"  => ["required", "exists:drive_duty_schedules,id"],
            "student_id"        => ["required", "exists:students,id"],
            "guardian_feedback" => ["required", "string"]
        ];
    }
}
