<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class HomeworkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->check_submitted) {
        $status = ___('online-examination.Submitted');
        $document = @globalAsset($this->check_submitted->homeworkUpload->path, '100X100.webp');
        $evaluated_marks = $this->check_submitted->marks;
        }else{
            $status = ___('online-examination.Not Submitted Yest');
            $document = null;
            $evaluated_marks = null;
        }
        return [
            'id'         => $this->id,
            'subject'        => $this->subject->name,
            'marks'         => $this->marks,
            'date'         => dateFormat($this->date),
            'submission_date'         => dateFormat($this->submission_date),
            'status' => $status,
            'document'            => $document,
            'evaluated_marks' => $evaluated_marks
        ];       
    }
}
