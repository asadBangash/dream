<?php

namespace App\Models;

use App\Models\Academic\Classes;
use App\Models\Staff\Department;
use App\Models\Upload;
use App\Models\Academic\Section;
use App\Models\StudentInfo\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NoticeBoard extends BaseModel
{
    use HasFactory;

    protected $casts = [
        'visible_to' => 'array',
    ];

    public function attachmentFile()
    {
        return $this->belongsTo(Upload::class, 'attachment', 'id');
    }

    public function roles()
    {
        return Role::whereIn('id', $this->visible_to ?? []);
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }


    public function getVisibleRoleNamesAttribute()
    {
        return $this->roles()->pluck('name')->join(', ');
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id', 'id');
    }


    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function defaultTranslate()
    {

        $relation = $this->hasOne(NoticeBoardTranslate::class, 'notice_board_id')->where('locale', request()->locale ?? config('app.locale'));
        if ($relation->exists()) {
            return $relation;
        } else {
            return $this->hasOne(NoticeBoardTranslate::class, 'notice_board_id')->where('locale', 'en');
        }
    }


    public function translations()
    {
        return $this->hasMany(NoticeBoardTranslate::class, 'notice_board_id', 'id');
    }
}
