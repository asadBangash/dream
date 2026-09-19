<?php

namespace App\Http\Requests\Academic\ClassRoom;

use Illuminate\Foundation\Http\FormRequest;

class ClassRoomStoreRequest extends FormRequest
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
            'room_no'   => 'required|max:10|unique:class_rooms',
            'capacity'  => 'required|max:10',
            'status'    => 'required'
        ];
    }
}
