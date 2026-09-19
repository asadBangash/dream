<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiblingFeesDiscount extends Model
{

    protected $fillable = [
        'discount_title',
        'siblings_number',
        'discount_percentage'
    ];
}
