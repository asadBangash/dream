<?php

namespace App\Models\Examination;

use App\Models\BaseModel;
use App\Models\StudentInfo\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarksRegisterChildren extends BaseModel
{
    use HasFactory;

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function MarksRegister()
    {
        return $this->belongsTo(MarksRegister::class, 'marks_register_id', 'id');
    }
}
