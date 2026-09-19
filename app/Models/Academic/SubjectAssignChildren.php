<?php

namespace App\Models\Academic;

use App\Models\BaseModel;
use App\Models\Staff\Staff;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectAssignChildren extends BaseModel
{
    use HasFactory;

    public function subjectAssign()
    {
        return $this->belongsTo(SubjectAssign::class, 'subject_assign_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function teacher()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'id');
    }
}
