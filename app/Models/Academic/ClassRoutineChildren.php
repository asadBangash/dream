<?php

namespace App\Models\Academic;

use App\Models\BaseModel;
use App\Models\Staff\Staff;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoutineChildren extends BaseModel
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

    public function classRoutine()
    {
        return $this->belongsTo(ClassRoutine::class, 'class_routine_id', 'id');
    }
}
