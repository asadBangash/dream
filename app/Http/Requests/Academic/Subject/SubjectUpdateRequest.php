<?php

namespace App\Http\Requests\Academic\Subject;

use App\Rules\BranchUnique;
use Illuminate\Foundation\Http\FormRequest;

class SubjectUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = (int) $this->route('id');

        return [
            'name' => [
                'required',
                new BranchUnique('subjects', 'name', $id, null, ['type' => $this->input('type')]),
            ],
            'type' => ['required'],
            'status' => ['required', 'max:10'],
            'code' => ['required', 'max:50'],
        ];
    }
}
