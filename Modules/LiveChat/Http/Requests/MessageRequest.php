<?php

namespace Modules\LiveChat\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'message' => 'required:max:600',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [

            'message.required' => ___('validation.message_is_required'),
            'message.max' => ___('validation.message_must_be_less_than_600_characters'),           

        ];
    }
}
