<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Enums\Status;
use App\Models\Role;
use App\Models\Staff\Department;
use App\Models\Staff\Designation;
use App\Models\Staff\Staff;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * php artisan db:seed --class=DreamTuitionTeachersSeeder --force
 */
class DreamTuitionTeachersSeeder extends Seeder
{
    private const SHARED_BRANCH = 0;

    /** @var list<array{0: string, 1: string}> first_name, last_name */
    private array $teachers = [
        ['Gohar', 'Rahman'],
        ['Ikhlaq', ''],
        ['Naveed', ''],
        ['Abuzar', ''],
        ['Fayaz', ''],
        ['Khan', 'Muhammad'],
        ['Imdad', ''],
    ];

    public function run(): void
    {
        $designationId = $this->designationId();
        $departmentId = $this->departmentId();
        $genderId = (int) (\Illuminate\Support\Facades\DB::table('genders')->value('id') ?: 1);
        $permissions = Role::find(RoleEnum::TEACHER)?->permissions ?? [];

        $staffId = 3001;

        foreach ($this->teachers as [$first, $last]) {
            $display = trim($first . ' ' . $last);
            $slug = Str::slug($display ?: $first);
            $email = $slug . '@dream.test';

            if (User::withoutGlobalScopes()->where('email', $email)->exists()) {
                $this->command?->warn("Skip existing: {$email}");
                $staffId++;

                continue;
            }

            $user = new User();
            $user->name = $display ?: $first;
            $user->email = $email;
            $user->phone = '0300' . str_pad((string) $staffId, 7, '0', STR_PAD_LEFT);
            $user->password = Hash::make('123456');
            $user->email_verified_at = now();
            $user->role_id = RoleEnum::TEACHER;
            $user->permissions = $permissions;
            $user->uuid = (string) Str::uuid();
            $user->branch_id = self::SHARED_BRANCH;
            $user->save();

            $staff = new Staff();
            $staff->user_id = $user->id;
            $staff->staff_id = $staffId;
            $staff->role_id = RoleEnum::TEACHER;
            $staff->designation_id = $designationId;
            $staff->department_id = $departmentId;
            $staff->first_name = $first;
            $staff->last_name = $last ?: null;
            $staff->email = $email;
            $staff->gender_id = $genderId;
            $staff->dob = '1990-01-01';
            $staff->joining_date = now()->format('Y-m-d');
            $staff->phone = $user->phone;
            $staff->status = Status::ACTIVE;
            $staff->branch_id = self::SHARED_BRANCH;
            $staff->upload_documents = [];
            $staff->save();

            $this->command?->line("Teacher: {$display} ({$email} / password: 123456)");
            $staffId++;
        }

        $this->command?->info('Dream Tuition teachers seeded.');
    }

    private function designationId(): int
    {
        $row = Designation::withoutGlobalScopes()->firstOrCreate(
            ['name' => 'Teacher', 'branch_id' => self::SHARED_BRANCH],
            ['status' => Status::ACTIVE]
        );

        return (int) $row->id;
    }

    private function departmentId(): int
    {
        $row = Department::withoutGlobalScopes()
            ->where('name', 'School Tuition')
            ->first();

        if ($row) {
            return (int) $row->id;
        }

        $row = Department::withoutGlobalScopes()->firstOrCreate(
            ['name' => 'School Tuition', 'branch_id' => self::SHARED_BRANCH],
            ['status' => Status::ACTIVE]
        );

        return (int) $row->id;
    }
}
