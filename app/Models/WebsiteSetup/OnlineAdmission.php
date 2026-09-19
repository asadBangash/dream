<?php

namespace App\Models\WebsiteSetup;

use App\Models\Upload;
use App\Models\Academic\Classes;
use App\Models\Academic\Section;
use Illuminate\Database\Eloquent\Model;
use App\Models\StudentInfo\OnlineAdmissionFeesAssign;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OnlineAdmission extends Model
{
    use HasFactory;

    protected $casts = [
        'upload_documents' => 'array',
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class, 'classes_id', 'id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }

    public function fees()
    {
        return $this->hasOne(OnlineAdmissionFeesAssign::class, 'id', 'fees_assign_id');
    }

    public function payslip_img()
    {
        return $this->belongsTo(Upload::class, 'payslip_image_id', 'id');
    }

    public function student_img()
    {
        return $this->belongsTo(Upload::class, 'student_image_id', 'id');
    }

    public function gurdian_img()
    {
        return $this->belongsTo(Upload::class, 'gurdian_image_id', 'id');
    }

    public function father_img()
    {
        return $this->belongsTo(Upload::class, 'father_image_id', 'id');
    }

    public function mother_img()
    {
        return $this->belongsTo(Upload::class, 'mother_image_id', 'id');
    }


    public function previous_img()
    {
        return $this->belongsTo(Upload::class, 'previous_school_image_id', 'id');
    }
}
