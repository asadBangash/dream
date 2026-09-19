<?php

namespace App\Http\Requests\GeneralSetting;

use Illuminate\Foundation\Http\FormRequest;

class StorageUpdateRequest extends FormRequest
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
        if(\Request::get('file_system') == 's3'){
            return [
                'aws_access_key_id' => 'required',
                'aws_secret_key' => 'required',
                'aws_region' => 'required',
                'aws_bucket' => 'required',
                'aws_endpoint' => 'required'
            ];
        }

        return [
            'file_system' => 'required',
        ];
        
    }
}
