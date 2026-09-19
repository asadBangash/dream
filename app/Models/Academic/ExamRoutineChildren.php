<?php

namespace App\Models\Academic;

use App\Models\BaseModel;
use App\Models\Examination\ExamType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamRoutineChildren extends BaseModel
{
    use HasFactory;

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function teacher()
    {
        return $this->belongsTo(Staff::class, 'teacher_id', 'id');
    }

    public function timeSchedule()
    {
        return $this->belongsTo(TimeSchedule::class, 'time_schedule_id', 'id');
    }

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_room_id', 'id');
    }

    public function examRoutine()
    {
        return $this->belongsTo(ExamRoutine::class, 'exam_routine_id', 'id');
    }

    public function class()
    {
        return $this->hasOneThrough(
            Classes::class,
            ExamRoutine::class,
            'id',             // Foreign key on ExamRoutine table...
            'id',             // Foreign key on Classes table...
            'exam_routine_id', // Local key on ExamRoutineChildren...
            'classes_id'      // Local key on ExamRoutine...
        );
    }

    public function section()
    {
        return $this->hasOneThrough(
            Section::class,
            ExamRoutine::class,
            'id',
            'id',
            'exam_routine_id',
            'section_id'
        );
    }


    public function exam_type()
    {
        return $this->hasOneThrough(
            ExamType::class,
            ExamRoutine::class,
            'id',
            'id',
            'exam_routine_id',
            'type_id'
        );
    }
}
