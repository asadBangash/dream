<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SystemNotification extends BaseModel
{
    use HasFactory;


    public static function myNotification(){
        if(Auth::check()){
            return Auth::user()->unreadNotifications;
        }else{
            return [];
        }
    }
}
