<?php

namespace Database\Seeders\Demo;

use App\Enums\RoleEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        $superPermissions = Role::find(RoleEnum::SUPERADMIN)?->permissions ?? [];
        $adminPermissions = Role::find(RoleEnum::ADMIN)?->permissions ?? [];

        User::query()->whereIn('email', [
            'superadmin@example.com',
            'boysadmin@example.com',
            'girlsadmin@example.com',
        ])->delete();

        $this->createUser([
            'name'        => 'Super Admin',
            'email'       => 'superadmin@example.com',
            'phone'       => '+92 300 1110001',
            'role_id'     => RoleEnum::SUPERADMIN,
            'branch_id'   => DemoContext::$boysBranchId,
            'permissions' => $superPermissions,
        ]);

        $this->createUser([
            'name'        => 'Ahmed Khan',
            'email'       => 'boysadmin@example.com',
            'phone'       => '+92 300 1110002',
            'role_id'     => RoleEnum::ADMIN,
            'branch_id'   => DemoContext::$boysBranchId,
            'permissions' => $adminPermissions,
        ]);

        $this->createUser([
            'name'        => 'Ayesha Khan',
            'email'       => 'girlsadmin@example.com',
            'phone'       => '+92 300 1110003',
            'role_id'     => RoleEnum::ADMIN,
            'branch_id'   => DemoContext::$girlsBranchId,
            'permissions' => $adminPermissions,
        ]);
    }

    private function createUser(array $data): User
    {
        $user = new User();
        $user->name              = $data['name'];
        $user->email             = $data['email'];
        $user->phone             = $data['phone'];
        $user->email_verified_at = now();
        $user->password          = Hash::make(DemoContext::PASSWORD);
        $user->remember_token    = Str::random(10);
        $user->role_id           = $data['role_id'];
        $user->branch_id         = $data['branch_id'];
        $user->permissions       = $data['permissions'];
        $user->upload_id         = 1;
        $user->designation_id    = null;
        $user->uuid              = Str::uuid();
        $user->save();

        return $user;
    }
}
