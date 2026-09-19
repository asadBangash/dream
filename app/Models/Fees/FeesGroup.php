<?php

namespace App\Models\Fees;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeesGroup extends BaseModel
{
    use HasFactory;

    public function scopeActive($query)
    {
        return $query->where('status', \App\Enums\Status::ACTIVE);
    }

    public function feeAssigns()
    {
        return $this->hasMany(FeesAssign::class, 'fees_group_id', 'id');
    }

    public function feeMasters()
    {
        return $this->hasMany(FeesMaster::class, 'fees_group_id', 'id');
    }
}
