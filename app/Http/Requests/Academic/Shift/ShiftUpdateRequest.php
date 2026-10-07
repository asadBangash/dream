<?php

namespace App\Http\Requests\Academic\Shift;

use App\Rules\BranchUnique;
use Illuminate\Foundation\Http\FormRequest;

class ShiftUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = (int) $this->route('id');

        return [
            'name' => ['required', 'max:255', new BranchUnique('shifts', 'name', $id)],
            'status' => ['required'],
        ];
    }
}
