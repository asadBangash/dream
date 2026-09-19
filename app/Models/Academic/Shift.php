<?php

namespace App\Models\Academic;

use App\Models\BaseModel;
use App\Models\ShiftTranslate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name','status'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', \App\Enums\Status::ACTIVE);
    }

    public function defaultTranslate()
    {
        $relation = $this->hasOne(ShiftTranslate::class, 'shift_id')->where('locale', request()->locale ?? config('app.locale'));
        if ($relation->exists()) {
            return $relation;
        } else {
            return $this->hasOne(Shift::class, 'id','id');
        }
    }


    public function translations()
    {
        return $this->hasMany(ShiftTranslate::class, 'shift_id', 'id');
    }
}
