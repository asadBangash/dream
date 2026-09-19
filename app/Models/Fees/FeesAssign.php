<?php

namespace App\Models\Fees;

use App\Models\Academic\Classes;
use App\Models\Academic\Section;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\Gender;
use App\Models\StudentInfo\StudentCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeesAssign extends BaseModel
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
    public function category()
    {
        return $this->belongsTo(StudentCategory::class, 'category_id', 'id');
    }
    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id', 'id');
    }
    public function feesGroup()
    {
        return $this->belongsTo(FeesGroup::class, 'fees_group_id', 'id');
    }

    public function feesAssignChilds()
    {
        return $this->hasMany(FeesAssignChildren::class, 'fees_assign_id', 'id');
    }

    public function feesGroupChilds()
    {
        return $this->hasMany(FeesMaster::class, 'fees_assign_id', 'id');
    }
}
