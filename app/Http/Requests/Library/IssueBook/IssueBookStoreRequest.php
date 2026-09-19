<?php

namespace App\Http\Requests\Library\IssueBook;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class IssueBookStoreRequest extends FormRequest
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
            'book'         => 'required',
            'member'       => 'required',
            'issue_date'   => 'required|date',
            'return_date'  => 'required|date|after_or_equal:issue_date',
            'phone'        => 'required'
        ];
    }
}
