<?php

namespace Modules\MainApp\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackageChild extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    public function feature()
    {
        return $this->belongsTo(Feature::class, 'feature_id', 'id');
    }
}
