<?php

namespace App\Models\Academic;

use App\Models\BaseModel;
use App\Models\Examination\ExamType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamRoutine extends BaseModel
{
    use HasFactory;

    public function scopeActive($query)
    {
        return $query->where('status', \App\Enums\Status::ACTIVE);
    }

    public function getTeacherNameAttribute()
    {
        $subject_assign = SubjectAssign::with('subjectTeacher.teacher')->where('session_id', setting('session'))
        ->where('classes_id', $this->classes_id)
        ->where('section_id', $this->section_id)
        ->first();

        $subject_assigned_chilldren = $subject_assign->subjectTeacher->where('subject_id', $this->subject_id)->first()->teacher;
        return $subject_assigned_chilldren->first_name .' '. $subject_assigned_chilldren->last_name;
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'classes_id', 'id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(ExamType::class, 'type_id', 'id');
    }

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
    public function examRoutineChildren()
    {
        return $this->hasMany(ExamRoutineChildren::class, 'exam_routine_id', 'id');
    }
}
