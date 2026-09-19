<?php

namespace App\Models\Examination;

use App\Models\Academic\Classes;
use App\Models\Academic\Section;
use App\Models\Academic\Subject;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAssign extends BaseModel
{
    use HasFactory;

    protected $casts = [
        'exam_types'             => 'array',
        'sections'               => 'array',
        'subjects'               => 'array',
        'marks_distribution'     => 'array',
    ];

    public function mark_distribution()
    {
        return $this->hasmany(ExamAssignChildren::class, 'exam_assign_id', 'id');
    }

    public function exam_type()
    {
        return $this->belongsTo(ExamType::class, 'exam_type_id', 'id');
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

    public function scopeActive($query)
    {
        return $query->where('status', \App\Enums\Status::ACTIVE);
    }
}
