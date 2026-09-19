<?php

namespace App\Models;

use App\Models\Academic\Classes;
use App\Models\Academic\Section;
use App\Models\Academic\Subject;
use App\Models\Examination\ExamType;
use App\Models\StudentInfo\Student;
use Illuminate\Database\Eloquent\Model;

class MarkSheetApproval extends Model
{
    protected $fillable = ['session_id', 'classes_id', 'section_id', 'exam_type_id', 'student_id', 'remarks', 'status'];

    public function class()
    {
        return $this->belongsTo(Classes::class, 'classes_id', 'id');
    }
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }

    public function exam_type()
    {
        return $this->belongsTo(ExamType::class, 'exam_type_id', 'id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
}
