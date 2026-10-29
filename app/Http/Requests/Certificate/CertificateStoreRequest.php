<?php

namespace App\Http\Requests\Certificate;

use Illuminate\Foundation\Http\FormRequest;

class CertificateStoreRequest extends FormRequest
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
            'title'                   => ['nullable', 'string', 'max:255'],
            'top_text'                => ['nullable', 'string', 'max:255'],
            'description'             => ['nullable', 'string'],
            'bottom_left_text'        => ['nullable', 'string'],
            'bottom_right_text'       => ['nullable', 'string'],
            'bg_image'                => ['nullable', 'image', 'max:5120'],
            'bottom_left_signature'   => ['nullable', 'image', 'max:5120'],
            'bottom_right_signature'  => ['nullable', 'image', 'max:5120'],
        ];
    }
}
