<?php

namespace App\Http\Requests\IdCard;

use App\Enums\IdCardType;
use App\Models\IdCard;
use Illuminate\Foundation\Http\FormRequest;

class IdCardSearchRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $idCard = IdCard::find($this->input('id_card'));
        $isTeacher = $idCard && ($idCard->card_type ?? IdCardType::STUDENT) === IdCardType::TEACHER;

        if ($isTeacher) {
            $this->merge([
                'class'   => null,
                'section' => null,
                'student' => null,
            ]);
        } else {
            $this->merge(['staff' => null]);
        }
    }

    public function rules()
    {
        $idCard = IdCard::find($this->input('id_card'));
        $isTeacher = $idCard && ($idCard->card_type ?? IdCardType::STUDENT) === IdCardType::TEACHER;

        return [
            'id_card' => 'required',
            'class'   => $isTeacher ? 'nullable' : 'required',
            'section' => $isTeacher ? 'nullable' : 'required',
            'staff'   => 'nullable|integer',
            'student' => 'nullable|integer',
        ];
    }
}
