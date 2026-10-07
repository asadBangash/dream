<?php

/**
 * Reset super admin login (local/server). Run: php scripts/reset-superadmin.php
 */

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$domain = env('APP_DOMAIN', 'dream.test');
$password = $argv[1] ?? '123456';
$email = $argv[2] ?? env('SUPERADMIN_EMAIL') ?: ('superadmin@' . $domain);

$user = User::query()->where('role_id', 1)->orderBy('id')->first();

if (! $user) {
    $user = User::query()->where('email', 'like', 'superadmin@%')->first();
}

if (! $user) {
    fwrite(STDERR, "No super admin found. Run: php artisan app:setup --fresh\n");
    exit(1);
}

$user->email = $email;
$user->password = Hash::make($password);
$user->status = 1;
$user->email_verified_at = $user->email_verified_at ?? now();
$user->save();

echo "Super admin updated.\n";
echo "Email:    {$user->email}\n";
echo "Password: {$password}\n";
echo "Login:    " . rtrim(env('APP_URL', 'http://dream.test'), '/') . "/login\n";
