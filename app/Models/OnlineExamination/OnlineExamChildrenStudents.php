<?php

namespace App\Models\OnlineExamination;

use App\Models\BaseModel;
use App\Models\StudentInfo\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineExamChildrenStudents extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'online_exam_id',
        'student_id'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function onlineExam()
    {
        return $this->hasOne(OnlineExam::class, 'id', 'online_exam_id');
    }
}
