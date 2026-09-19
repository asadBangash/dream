<?php

namespace Modules\MainApp\Http\Requests\Feature;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'title'          => 'required|max:255|unique:features,title,'.Request()->id,
            'description'    => 'required',
            'position'       => 'required',
            'status'         => 'required',
        ];
    }
}
