<?php

namespace App\Models\Fees;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeesMaster extends BaseModel
{
    use HasFactory;

    public function feesMasterChilds()
    {
        return $this->hasMany(FeesMasterChildren::class, 'fees_master_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', \App\Enums\Status::ACTIVE);
    }

    public function group()
    {
        return $this->belongsTo(FeesGroup::class, 'fees_group_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(FeesType::class, 'fees_type_id', 'id');
    }
}
