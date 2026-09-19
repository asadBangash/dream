<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EarlyPaymentDiscountStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'discount_title' => 'nullable|array',
            'discount_title.*' => 'nullable|string|max:255',
            'start_date' => 'nullable|array',
            'start_date.*' => 'nullable|date',
            'end_date' => 'nullable|array',
            'end_date.*' => 'nullable|date|after_or_equal:start_date.*',
            'discount_percentage' => 'nullable|array',
            'discount_percentage.*' => 'nullable|numeric|min:0|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'discount_title.*.string' => 'The discount title must be a string.',
            'discount_title.*.max' => 'The discount title may not be greater than 255 characters.',

            'start_date.*.date' => 'The start date must be a valid date.',

            'end_date.*.date' => 'The end date must be a valid date.',
            'end_date.*.after_or_equal' => 'The end date must be a date after or equal to the start date.',

            'discount_percentage.*.numeric' => 'The discount percentage must be a number.',
            'discount_percentage.*.min' => 'The discount percentage must be at least 0%.',
            'discount_percentage.*.max' => 'The discount percentage may not be greater than 100%.',
        ];
    }
}
