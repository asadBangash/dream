<?php

namespace App\Models\StudentInfo;

use App\Models\Academic\Classes;
use App\Models\Academic\Section;
use App\Models\Academic\Shift;
use App\Models\Academic\SubjectAssignChildren;
use App\Models\BaseModel;
use App\Models\HomeworkStudent;
use App\Models\Session;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SessionClassStudent extends BaseModel
{
    use HasFactory;

    /**
     * Student list & reports: avoid nested Student global scope breaking Super Admin branch switch.
     */
    public function scopeForStudentListing(Builder $query): Builder
    {
        // BaseModel branch scope + whereHas('student') used to double-apply Student scope and hide rows.
        $query->withoutGlobalScope('branch_id');

        $query->whereHas('student', fn (Builder $q) => $q->withoutGlobalScopes());

        $branchId = effectiveBranchScopeId();
        if (hasModule('MultiBranch') && $branchId) {
            $query->where(function (Builder $outer) use ($branchId) {
                $outer->whereHas('student', fn (Builder $q) => $q->withoutGlobalScopes()->where('branch_id', $branchId))
                    ->orWhereHas('class', fn (Builder $q) => $q->withoutGlobalScopes()->where('branch_id', $branchId));
            });
        }

        return $query->with([
            'student' => fn ($q) => $q->withoutGlobalScopes(),
            'class' => fn ($q) => $q->withoutGlobalScopes(),
            'section' => fn ($q) => $q->withoutGlobalScopes(),
        ]);
    }

    public function subjectAssignChildren()
    {
        return $this->hasMany(SubjectAssignChildren::class, 'subject_assign_id', 'classes_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function session()
    {
        return $this->belongsTo(Session::class, 'session_id', 'id');
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'classes_id', 'id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id', 'id');
    }

    public function homeworkStudent()
    {
        return $this->belongsTo(HomeworkStudent::class, 'student_id', 'student_id');
    }
}
