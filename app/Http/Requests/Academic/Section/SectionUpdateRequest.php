<?php

namespace App\Http\Requests\Academic\Section;

use App\Rules\BranchUnique;
use Illuminate\Foundation\Http\FormRequest;

class SectionUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = (int) $this->route('id');

        return [
            'name' => ['required', 'max:255', new BranchUnique('sections', 'name', $id)],
            'status' => ['required'],
        ];
    }
}
