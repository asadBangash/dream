<?php

namespace App\Models\Fees;

use App\Models\AssignFeesDiscount;
use App\Models\BaseModel;
use App\Models\Fees\FeesAssign;
use App\Models\Fees\FeesMaster;
use App\Models\Fees\FeesCollect;
use App\Models\StudentInfo\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeesAssignChildren extends BaseModel
{
    use HasFactory;

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function feesMaster()
    {
        return $this->belongsTo(FeesMaster::class, 'fees_master_id', 'id');
    }

    public function feesCollect()
    {
        return $this->hasOne(FeesCollect::class, 'fees_assign_children_id', 'id');
    }

    public function feesAssign()
    {
        return $this->belongsTo(FeesAssign::class, 'fees_assign_id', 'id');
    }

    public function feesDiscount()
    {
        return $this->hasOne(AssignFeesDiscount::class, 'fees_assign_children_id', 'id');
    }

}
