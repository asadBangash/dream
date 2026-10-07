<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

$email = $argv[1] ?? 'superadmin@tdelcta.com';
$password = $argv[2] ?? '123456';

$user = User::query()->where('email', $email)->first();
echo "User by email: " . ($user ? "found id={$user->id}" : "NOT FOUND") . PHP_EOL;

if ($user) {
    echo "Hash check: " . (Hash::check($password, $user->password) ? 'OK' : 'FAIL') . PHP_EOL;
    echo "Auth::attempt: " . (Auth::attempt(['email' => $email, 'password' => $password]) ? 'OK' : 'FAIL') . PHP_EOL;
    Auth::logout();
}

echo "All superadmin-like emails:" . PHP_EOL;
foreach (User::query()->where('role_id', 1)->orWhere('email', 'like', 'superadmin@%')->get(['id', 'email']) as $u) {
    echo "  {$u->id} {$u->email}" . PHP_EOL;
}
