<?php

namespace App\Models\Academic;

use App\Models\BaseModel;
use App\Models\ClassSectionTranslate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name','status'
    ];

    protected $appends = ['section_tran'];

    public function getSectionTranAttribute()
    {
        $translation = $this->defaultTranslate()->first();
        return $translation->name ?? $this->name;

    }

    public function scopeActive($query)
    {
        return $query->where('status', \App\Enums\Status::ACTIVE);
    }

    public function defaultTranslate()
    {
        $relation = $this->hasOne(ClassSectionTranslate::class, 'section_id')->where('locale', request()->locale ?? config('app.locale'));
        if ($relation->exists()) {
            return $relation;
        } else {
            return $this->hasOne(ClassSectionTranslate::class, 'section_id')->where('locale', 'en');
        }
    }


    public function translations()
    {
        return $this->hasMany(ClassSectionTranslate::class, 'section_id', 'id');
    }
}
