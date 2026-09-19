<?php

namespace App\Http\Requests\Fees\Assign;

use Illuminate\Foundation\Http\FormRequest;

class FeesAssignStoreRequest extends FormRequest
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
     * fees_group_id
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'fees_group'         => 'required|max:25',
            'class'              => 'required|max:25',
            'section'            => 'required|max:25'
        ];
    }
}
