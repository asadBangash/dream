<?php

/**
 * Quick server diagnostics (SSH): php scripts/diagnose-server.php
 */

$base = dirname(__DIR__);

echo "=== Dream Tuition — server diagnostics ===\n\n";
echo "PHP version: " . PHP_VERSION . (version_compare(PHP_VERSION, '8.2.0', '>=') ? " (OK)\n" : " (NEED 8.2+)\n");
echo "Project root: {$base}\n";
echo "public/index.php: " . (is_file($base . '/public/index.php') ? "yes\n" : "MISSING\n");
echo "vendor/autoload.php: " . (is_file($base . '/vendor/autoload.php') ? "yes\n" : "MISSING — run composer install\n");
echo ".env: " . (is_file($base . '/.env') ? "yes\n" : "MISSING\n");

if (! is_file($base . '/vendor/autoload.php')) {
    exit(1);
}

require $base . '/vendor/autoload.php';

try {
    $app = require $base . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
} catch (Throwable $e) {
    echo "\nBootstrap FAILED: " . $e->getMessage() . "\n";
    exit(1);
}

echo "APP_URL: " . config('app.url') . "\n";
echo "APP_ENV: " . config('app.env') . "\n";
echo "APP_KEY set: " . (config('app.key') ? 'yes' : 'NO — run php artisan key:generate') . "\n";
echo "DB_DATABASE: " . env('DB_DATABASE') . "\n";
echo "DB_HOST: " . env('DB_HOST') . "\n";

try {
    Illuminate\Support\Facades\DB::connection()->getPdo();
    echo "DB connection: OK\n";
} catch (Throwable $e) {
    echo "DB connection: FAILED — " . $e->getMessage() . "\n";
    exit(1);
}

$tables = ['migrations', 'users', 'branches'];
foreach ($tables as $table) {
    echo "Table {$table}: " . (Illuminate\Support\Facades\Schema::hasTable($table) ? 'yes' : 'NO') . "\n";
}

if (Illuminate\Support\Facades\Schema::hasTable('users')) {
    echo "User count: " . \App\Models\User::count() . "\n";
}

echo "\nNext if users=0 or migrations missing:\n";
echo "  php artisan app:setup --fresh -vvv\n";
echo "Or:\n";
echo "  php artisan migrate --path=database/migrations/tenant --force\n";
echo "  php artisan db:seed --force\n";

exit(0);
