<?php

namespace App\Http\Requests\Examination\Type;

use App\Rules\BranchUnique;
use Illuminate\Foundation\Http\FormRequest;

class ExamTypeUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = (int) $this->route('id');

        return [
            'name' => ['required', 'max:255', new BranchUnique('exam_types', 'name', $id)],
        ];
    }
}
