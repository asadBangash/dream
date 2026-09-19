<?php

namespace App\Models\Staff;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', \App\Enums\Status::ACTIVE);
    }


    public function manager()
    {
        return $this->belongsTo(Staff::class, 'staff_user_id');
    }
}
