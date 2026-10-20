<?php

namespace App\Models;

use App\Models\Academic\Classes;
use App\Models\Academic\Section;
use App\Models\Academic\Subject;
use App\Models\Staff\Staff;

class TeacherLecture extends BaseModel
{
    protected $fillable = [
        'session_id', 'classes_id', 'section_id', 'subject_id', 'staff_id',
        'title', 'description', 'lecture_type', 'upload_id', 'video_url', 'status', 'created_by',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', \App\Enums\Status::ACTIVE);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'classes_id', 'id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function upload()
    {
        return $this->belongsTo(Upload::class, 'upload_id', 'id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'id');
    }
}
