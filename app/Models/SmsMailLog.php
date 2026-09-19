<?php

namespace App\Models;

use App\Models\Role;
use App\Models\User;
use App\Enums\UserType;
use App\Models\Academic\Classes;
use App\Models\Academic\Section;
use Illuminate\Database\Eloquent\Model;
use App\Models\StudentInfo\SessionClassStudent;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SmsMailLog extends BaseModel
{
    use HasFactory;

    protected $casts = [
        'role_ids'            => 'array',
        'individual_user_ids' => 'array',
        'section_ids'         => 'array'
    ];


    public function getUserTypeValueAttribute()
    {
        if($this->user_type == UserType::ROLE) {

            $roles = Role::whereIn('id', $this->role_ids)->get();
            $role = '';
            foreach($roles as $key => $role) {
                if($key == 0) {
                    $role .= $role->name;
                } else {
                    $role .= ','.$role->name;
                }
            }

            return $role;


        } elseif($this->user_type == UserType::INDIVIDUAL) {

            $users = User::whereIn('id', $this->individual_user_ids)->get();
            $user_name = '';
            foreach($users as $key => $user) {
                if($key == 0) {
                    $user_name .= $user->name;
                } else {
                    $user_name .= ','.$user->name;
                }
            }

            return $user_name;

        }  else {

            $class = Classes::find($this->class_id)->name;
            $sections = Section::whereIn('id', $this->section_ids)->get();

            $section_name = '';
            foreach($sections as $key => $section) {
                if($key == 0) {
                    $section_name .= $section->name;
                } else {
                    $section_name .= ','.$section->name;
                }
            }

            return "Class: $class, Section: $section_name";

        }

    }

}
