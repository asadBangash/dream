<?php

namespace App\Models;

use App\Models\Fees\FeesAssignChildren;
use Illuminate\Database\Eloquent\Model;

class AssignFeesDiscount extends Model
{
    public function feesAssignChildren()
    {
        return $this->belongsTo(FeesAssignChildren::class, 'fees_assign_children_id', 'id');
    }

}
