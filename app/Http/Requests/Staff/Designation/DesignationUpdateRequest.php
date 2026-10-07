<?php

namespace App\Http\Requests\Staff\Designation;

use App\Rules\BranchUnique;
use Illuminate\Foundation\Http\FormRequest;

class DesignationUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = (int) $this->route('id');

        return [
            'name' => ['required', 'max:255', new BranchUnique('designations', 'name', $id)],
            'status' => ['required'],
        ];
    }
}
