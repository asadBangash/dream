<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactInfoTranslate extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'contact_info_id',
        'locale',
    ];
}