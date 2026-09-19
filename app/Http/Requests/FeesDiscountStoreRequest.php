<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeesDiscountStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'siblings_number'        => 'nullable|array',
            'siblings_number.*'      => 'nullable|integer|min:0',
            'discount_title'         => 'nullable|array',
            'discount_title.*'       => 'nullable|string|max:255',
            'discount_percentage'    => 'nullable|array',
            'discount_percentage.*'  => 'nullable|numeric|min:0|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'siblings_number.required'       => 'The siblings number field is required.',
            'siblings_number.*.required'     => 'siblings number is required.',
            'siblings_number.*.integer'      => 'siblings number must be an integer.',
            'siblings_number.*.min'          => 'siblings number must be at least 0.',

            'discount_title.required'        => 'The discount title field is required.',
            'discount_title.*.required'      => 'discount title is required.',
            'discount_title.*.string'        => 'discount title must be a string.',
            'discount_title.*.max'           => 'discount title may not be greater than 255 characters.',

            'discount_percentage.required'   => 'The discount percentage field is required.',
            'discount_percentage.*.required' => 'discount percentage is required.',
            'discount_percentage.*.numeric'  => 'discount percentage must be a number.',
            'discount_percentage.*.min'      => 'discount percentage must be at least 0%.',
            'discount_percentage.*.max'      => 'discount percentage may not be greater than 100%.',
        ];
    }

}
