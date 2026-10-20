<?php

namespace App\Http\Requests;

use App\Enums\LectureType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeacherLectureStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'class'         => 'required|integer',
            'section'       => 'required|integer',
            'subject'       => 'required|integer',
            'title'         => 'required|string|max:255',
            'lecture_type'  => ['required', Rule::in([LectureType::PDF, LectureType::VIDEO, LectureType::LECTURE])],
            'description'   => 'nullable|string',
            'video_url'     => 'nullable|url|max:500',
            'document'      => 'nullable|file|max:51200|mimes:pdf,doc,docx,ppt,pptx,mp4,mov,avi,zip',
            'status'        => 'required|integer',
        ];
    }
}
