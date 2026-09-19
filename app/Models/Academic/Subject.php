<?php

namespace App\Models\Academic;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\Academic\SubjectAssignChildren;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name','code','type','status'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', \App\Enums\Status::ACTIVE);
    }

    public function subjectAssignChildrens(): HasMany
    {
        return $this->hasMany(SubjectAssignChildren::class, 'subject_id', 'id');
    }
}
