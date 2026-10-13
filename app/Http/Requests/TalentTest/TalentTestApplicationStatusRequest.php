<?php

namespace App\Http\Requests\TalentTest;

use App\Enums\TalentTestApplicationStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TalentTestApplicationStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in([
                TalentTestApplicationStatus::PENDING,
                TalentTestApplicationStatus::REVIEWED,
                TalentTestApplicationStatus::APPROVED,
                TalentTestApplicationStatus::REJECTED,
            ])],
            'admin_remarks' => 'nullable|string|max:2000',
        ];
    }
}
