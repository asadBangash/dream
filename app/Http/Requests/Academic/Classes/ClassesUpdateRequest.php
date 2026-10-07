<?php

namespace App\Http\Requests\Academic\Classes;

use App\Rules\BranchUnique;
use Illuminate\Foundation\Http\FormRequest;

class ClassesUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = (int) $this->route('id');

        return [
            'name' => ['required', 'max:255', new BranchUnique('classes', 'name', $id)],
            'status' => ['required'],
        ];
    }
}
