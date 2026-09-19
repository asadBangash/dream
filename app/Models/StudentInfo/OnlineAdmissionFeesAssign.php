<?php

namespace App\Models\StudentInfo;

use App\Models\Academic\Classes;
use App\Models\Academic\Section;
use App\Models\BaseModel;
use App\Models\Fees\FeesGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OnlineAdmissionFeesAssign extends BaseModel
{
    use HasFactory;

    public function group()
    {
        return $this->belongsTo(FeesGroup::class, 'fees_group_id', 'id');
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id', 'id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }
}
