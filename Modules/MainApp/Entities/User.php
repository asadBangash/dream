<?php

namespace Modules\MainApp\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'date_of_birth',
        'upload_id',
    ];
}
