<?php

namespace App\Http\Requests\API;

use App\Traits\ReturnFormatTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProfileUpdateRequest extends FormRequest
{
    use ReturnFormatTrait;
    
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
            'image'         => 'nullable|image',
            'first_name'    => 'required|max:255',
            'last_name'     => 'nullable|max:255',
            'date_of_birth' => 'nullable|date|before:' . date('Y-m-d'),
            'phone'         => 'required'
        ];
    }

    /**
     * Get the error messages json response for the defined validation rules.
     *
     * @return array
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($this->responseWithError(___('alert.validation_error'), [$validator->errors()])));
    }
}
