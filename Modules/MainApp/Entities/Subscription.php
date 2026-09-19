<?php

namespace Modules\MainApp\Entities;

use Modules\MainApp\Entities\Package;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $casts = [
        'features_name' => 'array',
        'features' => 'array',
    ];
    
    public function scopeActive($query)
    {
        return $query->where('status', \App\Enums\Status::ACTIVE);
    }
    
    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id', 'id');
    }
}
