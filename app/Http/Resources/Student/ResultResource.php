<?php

namespace App\Http\Resources\Student;

use App\Repositories\StudentPanel\ResultRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class ResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $result             = (new ResultRepository)->result($this->id);
        
        return [
            'title'         => $this->name,
            'status'        => $result['status'],
            'grade'         => $result['grade'],
            'number'        => $result['number'],
            'gpa'           => $result['gpa'],
            'marksheet_pdf' => $result['marksheet_pdf'],
        ];
    }
}
