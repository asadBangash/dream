<?php

namespace App\Http\Requests\Staff\Department;

use App\Rules\BranchUnique;
use Illuminate\Foundation\Http\FormRequest;

class DepartmentUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = (int) $this->route('id');

        return [
            'name' => ['required', 'max:255', new BranchUnique('departments', 'name', $id)],
            'status' => ['required'],
            'staff_user_id' => ['nullable'],
        ];
    }
}
