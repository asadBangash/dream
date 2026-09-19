<?php

namespace App\Models;

use App\Models\Upload;
use App\Models\HomeworkStudent;
use App\Models\Academic\Classes;
use App\Models\Academic\Section;
use App\Models\Academic\Subject;
use App\Models\Examination\ExamType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Homework extends BaseModel
{
    use HasFactory;

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
        return $this->belongsTo(Upload::class, 'document_id', 'id');
    }

    public function GetCheckSubmittedAttribute()
    {
        return HomeworkStudent::with('homeworkUpload')->where('student_id', Auth::user()->student->id)->where('homework_id', $this->id)->first();
    }
}
