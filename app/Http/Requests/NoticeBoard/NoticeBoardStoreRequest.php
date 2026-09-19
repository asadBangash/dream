<?php

namespace App\Http\Requests\NoticeBoard;

use Illuminate\Foundation\Http\FormRequest;

class NoticeBoardStoreRequest extends FormRequest
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
            'title'              => 'required',
            'publish_date'              => 'required',
            'date'              => 'required',
            'description'              => 'required',
        ];
    }
}
