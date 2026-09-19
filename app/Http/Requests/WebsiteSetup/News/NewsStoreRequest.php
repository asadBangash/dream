<?php

namespace App\Http\Requests\WebsiteSetup\News;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class NewsStoreRequest extends FormRequest
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
            'title'        => 'required',
            'date'         => 'required',
            'image'        => 'required',
            'publish_date' => 'required'
        ];
    }
}
