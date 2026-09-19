<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EarlyPaymentDiscount extends Model
{
    //

    protected $fillable = [
        'name', 'discount_percentage', 'start_date', 'end_date'
    ];
}
