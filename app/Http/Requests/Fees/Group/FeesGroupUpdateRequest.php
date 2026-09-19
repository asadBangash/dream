<?php

namespace App\Http\Requests\Fees\Group;

use Illuminate\Foundation\Http\FormRequest;

class FeesGroupUpdateRequest extends FormRequest
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
            'name'      => 'required|max:255|unique:fees_groups,name,'.Request()->id,
            'status'    => 'required'
        ];
    }
}
