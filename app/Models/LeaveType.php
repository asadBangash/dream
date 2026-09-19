<?php

namespace App\Models;

use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    protected $guarded = [];

    // Accessor for readable status
    public function getStatusAttribute()
    {
        return $this->active_status ? 'Active' : 'Inactive';
    }

    public function getRoleNameAttribute()
    {
        $roles = [
            RoleEnum::SUPERADMIN => 'Super Admin',
            RoleEnum::ADMIN => 'Admin',
            RoleEnum::STAFF => 'Staff',
            RoleEnum::ACCOUNTING => 'Accounting',
            RoleEnum::TEACHER => 'Teacher',
            RoleEnum::STUDENT => 'Student',
            RoleEnum::GUARDIAN => 'Guardian',
        ];

        return $roles[$this->role_id] ?? 'Unknown';
    }
}
