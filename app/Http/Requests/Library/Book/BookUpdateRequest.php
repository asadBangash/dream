<?php

namespace App\Http\Requests\Library\Book;

use Illuminate\Foundation\Http\FormRequest;

class BookUpdateRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name'            => 'required|unique:books,name,' . $this->id,
            'category'        => 'required',
            'code'            => 'required',
            'publisher_name'  => 'required',
            'author_name'     => 'required',
            'rack_no'         => 'required',
            'price'           => 'required',
            'quantity'        => 'required',
            'status'          => 'required',
            'description'     => 'required'
        ];
    }
}
