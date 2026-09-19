<?php

namespace App\Http\Requests\Academic\TimeSchedule;

use Illuminate\Foundation\Http\FormRequest;

class TimeScheduleStoreRequest extends FormRequest
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
        return [
            // 'name'   => 'required|max:255|unique:time_schedules',
            'type'       => 'required',
            'status'     => 'required',
            'start_time' => 'required',
            'end_time'   => 'required',
        ];
    }
}
