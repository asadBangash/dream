<?php

namespace Modules\MainApp\Entities;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;
use Modules\MainApp\Entities\PackageChild;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    public function packageChilds()
    {
        return $this->hasMany(PackageChild::class, 'package_id', 'id');
    }
    
    public function scopeActive($query)
    {
        return $query->where('status', \App\Enums\Status::ACTIVE);
    }
}
