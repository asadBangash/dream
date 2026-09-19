<?php

namespace App\Http\Resources\Teacher\Api;

use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeworkListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'subject' => @$this->subject->name,
            'class' => @$this->class->name,
            'section' => @$this->section->name,
            'date' => @dateFormat($this->date),
            'submission_date' => @dateFormat($this->submission_date),
            'marks' => $this->marks,
            'description' => Str::limit($this->description, 30, '...'),
            'document_path' => @globalAsset($this->upload->path, '100X100.webp'),
        ];
    }
}
