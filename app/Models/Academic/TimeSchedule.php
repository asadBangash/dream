<?php

namespace App\Models\Academic;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TimeSchedule extends BaseModel
{
    use HasFactory;

    protected $fillable = ['type','start_time','end_time'];

    public function scopeActive($query)
    {
        return $query->where('status', \App\Enums\Status::ACTIVE);
    }

    public function scopeClass($query)
    {
        return $query->where('type', 1);
    }

    public function scopeExam($query)
    {
        return $query->where('type', 2);
    }

    public function classRoutineChildrens(): HasMany
    {
        return $this->hasMany(ClassRoutineChildren::class, 'time_schedule_id', 'id');
    }

    public function classRoutineChildren(): HasOne
    {
        return $this->hasOne(ClassRoutineChildren::class, 'time_schedule_id', 'id');
    }
}
