<?php

namespace App\Models\WebsiteSetup;

use App\Models\BaseModel;
use App\Enums\TalentTestApplicationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TalentTestApplication extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'reference_no',
        'student_name',
        'father_name',
        'dob',
        'gender',
        'contact_number',
        'guardian_contact',
        'home_address',
        'current_class',
        'school_name',
        'last_exam_marks',
        'total_marks',
        'status',
        'admin_remarks',
    ];

    public function statusLabel(): string
    {
        return TalentTestApplicationStatus::label((int) $this->status);
    }
}
