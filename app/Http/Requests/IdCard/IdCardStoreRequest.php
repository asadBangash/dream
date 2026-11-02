<?php

namespace App\Http\Requests\IdCard;

use App\Enums\IdCardType;
use App\Rules\BranchUnique;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IdCardStoreRequest extends FormRequest
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
            'title'              => ['required', 'max:255', new BranchUnique('id_cards', 'title')],
            'card_type'          => ['required', Rule::in(IdCardType::values())],
        ];
    }
}
