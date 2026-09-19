<?php

namespace App\Http\Requests\Library\Member;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class MemberStoreRequest extends FormRequest
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
    public function rules(Request $r)
    {
        return [
            'member'      => 'required',
            'category'    => 'required',
            'status'      => 'required'
        ];
    }
}
