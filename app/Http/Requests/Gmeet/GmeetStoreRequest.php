<?php

namespace App\Http\Requests\Gmeet;

use Illuminate\Foundation\Http\FormRequest;

class GmeetStoreRequest extends FormRequest
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
            'title'              => 'required',
            'class'              => 'required',
            'section'              => 'required',
            'start'              => 'required',
            'end'                => 'required',
            'class'                => 'required',
            'gmeet_link'                => 'required',
        ];
    }
}
