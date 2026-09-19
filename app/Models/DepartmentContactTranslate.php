<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class DepartmentContactTranslate extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'department_contact_id',
        'locale',
    ];
}