<?php

namespace Modules\LiveChat\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LiveChatRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'pusher_app_id' => 'required|max:255',
            'pusher_app_key' => 'required|max:255',
            'pusher_app_secret' => 'required|max:255',
            'pusher_app_cluster' => 'required|max:255',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'pusher_app_id.required' => ___('validation.pusher_app_id_is_required'),
            'pusher_app_id.max' => ___('validation.pusher_app_id_must_not_be_greater_than_255_characters'),
            'pusher_app_key.required' => ___('validation.pusher_app_key_is_required'),
            'pusher_app_key.max' => ___('validation.pusher_app_key_must_not_be_greater_than_255_characters'),
            'pusher_app_secret.required' => ___('validation.pusher_app_secret_is_required'),
            'pusher_app_secret.max' => ___('validation.pusher_app_secret_must_not_be_greater_than_255_characters'),
            'pusher_app_cluster.required' => ___('validation.pusher_app_cluster_is_required'),
            'pusher_app_cluster.max' => ___('validation.pusher_app_cluster_must_not_be_greater_than_255_characters'),
        ];
    }
}
