<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Restore or create the Super Admin user (role_id = 1).
 *
 * Server:
 *   php artisan db:seed --class=SuperAdminSeeder --force
 *
 * Set in .env before seeding (optional):
 *   SUPERADMIN_EMAIL=superadmin@yourdomain.com
 *   SUPERADMIN_PASSWORD=your-secure-password
 */
class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $domain = env('APP_DOMAIN', 'localhost');
        $email = env('SUPERADMIN_EMAIL') ?: ('superadmin@' . $domain);
        $password = env('SUPERADMIN_PASSWORD', '123456');

        $role = Role::query()->find(RoleEnum::SUPERADMIN);
        if (! $role) {
            $this->fail('Super Admin role (id=1) not found. Run: php artisan db:seed --class=RoleSeeder --force');
        }

        $permissions = $role->permissions ?? [];
        $branchId = (int) (DB::table('branches')->min('id') ?? 1);

        $user = User::query()
            ->where('role_id', RoleEnum::SUPERADMIN)
            ->orderBy('id')
            ->first();

        if ($user && strcasecmp((string) $user->email, $email) !== 0) {
            $existing = User::query()->where('email', $email)->where('id', '!=', $user->id)->exists();
            if ($existing) {
                $this->fail("Email {$email} is already used by another user. Choose a different SUPERADMIN_EMAIL.");
            }
            $user->email = $email;
        }

        if (! $user) {
            $user = User::query()->where('email', $email)->first();
        }

        if ($user && (int) $user->role_id !== RoleEnum::SUPERADMIN) {
            $this->fail("User {$email} exists but is not Super Admin (role_id={$user->role_id}). Use another email or fix that account in the database.");
        }

        if (! $user) {
            $user = new User();
            $user->email = $email;
        }

        $user->name = 'Super Admin';
        $user->phone = $user->phone ?: '+92 300 1234567';
        $user->email_verified_at = $user->email_verified_at ?? now();
        $user->password = Hash::make($password);
        $user->remember_token = Str::random(10);
        $user->role_id = RoleEnum::SUPERADMIN;
        $user->permissions = $permissions;
        $user->status = 1;
        $user->branch_id = $user->branch_id ?: $branchId;
        $user->uuid = $user->uuid ?: (string) Str::uuid();
        $user->date_of_birth = $user->date_of_birth ?? now()->subYears(30)->toDateString();
        $user->save();

        $loginUrl = rtrim((string) env('APP_URL', ''), '/') . '/login';

        $this->command?->info('Super Admin ready.');
        $this->command?->line('Email:    ' . $user->email);
        $this->command?->line('Password: ' . (env('SUPERADMIN_PASSWORD') ? '(from SUPERADMIN_PASSWORD in .env)' : $password . ' (default — set SUPERADMIN_PASSWORD in .env and re-seed)'));
        if ($loginUrl !== '/login') {
            $this->command?->line('Login:    ' . $loginUrl);
        }
    }

    private function fail(string $message): void
    {
        if ($this->command) {
            $this->command->error($message);
        }
        throw new \RuntimeException($message);
    }
}
