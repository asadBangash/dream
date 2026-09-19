<?php

namespace App\Models\Examination;

use App\Models\Academic\ExamRoutine;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\Examination\MarksRegister;
use App\Models\OnlineExamination\OnlineExam;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamType extends BaseModel
{
    use HasFactory;

    public function scopeActive($query)
    {
        return $query->where('status', \App\Enums\Status::ACTIVE);
    }

    public function examAssigns()
    {
        return $this->hasMany(ExamAssign::class, 'exam_type_id', 'id');
    }

    public function examRoutines()
    {
        return $this->hasMany(ExamRoutine::class, 'type_id', 'id');
    }

    public function onlineExams()
    {
        return $this->hasMany(OnlineExam::class, 'exam_type_id', 'id');
    }

    public function markRegisters()
    {
        return $this->hasMany(MarksRegister::class, 'exam_type_id', 'id');
    }
}
