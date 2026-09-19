<?php

namespace App\Http\Requests\SmsMailLog;

use App\Enums\UserType;
use Illuminate\Foundation\Http\FormRequest;

class SmsMailLogStoreRequest extends FormRequest
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
        $title            = "required";
        $type             = "required";
        $user_type        = "required";

        $template_sms     = "";
        $template_mail    = "";
        $sms_description     = "";
        $mail_description    = "";

        if($this->type == 'sms') {
            $template_sms        = "required";
            $sms_description     = "required";
        }elseif($this->type == 'mail') {
            $template_mail       = "required";
            $mail_description    = "required";
        }

        $role_ids         = "";
        $role             = "";
        $users            = "";
        $class_id         = "";
        $section_ids      = "";

        if($this->user_type == UserType::ROLE) {
            $role_ids         = "required";
        } elseif($this->user_type == UserType::INDIVIDUAL) {
            $role             = "required";
            $users            = "required";
        } elseif($this->user_type == UserType::CLASSSECTION) {
            $class_id         = "required";
            $section_ids      = "required";
        }


        return [
            "title"            => "$title",
            "type"             => "$type",
            "user_type"        => "$user_type",

            "template_sms"     => "$template_sms",
            "template_mail"    => "$template_mail",
            "mail_description" => "$mail_description",
            "sms_description"  => "$sms_description",
            "role_ids"         => "$role_ids",
            "role"             => "$role",
            "users"            => "$users",
            "class_id"         => "$class_id",
            "section_ids"      => "$section_ids"
        ];
    }
}
