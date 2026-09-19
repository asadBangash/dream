<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OnlineExamStudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       $student = $this->student;

        // Check if student has answered
        $hasAnswered = $this->exam->studentAnswer
            ->pluck('student_id')
            ->contains($student->id);

        // Get result if available
        $result = $this->exam->studentAnswer
            ->where('student_id', $student->id)
            ->first()
            ->result ?? null;

        return [
            'id' => $student->id,
            'admission_no' => $student->admission_no,
            'name' => $student->first_name . ' ' . $student->last_name,
            'guardian_name' => $student->parent->guardian_name ?? null,
            'mobile' => $student->mobile,
            'has_answered' => $hasAnswered,
            'answer_url' => $hasAnswered
                ? route('online-exam.answer', [$this->exam->id, $student->id])
                : null,
            'result' => $result,
        ];
    }
}
