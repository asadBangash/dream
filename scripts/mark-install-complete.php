<?php

/**
 * Shared hosting: mark app as installed so routes skip /install redirect.
 * Does not use exec(), symlinks, or Artisan storage:link.
 *
 * Usage:
 *   php scripts/mark-install-complete.php
 */

$base = dirname(__DIR__);

require $base . '/vendor/autoload.php';

$app = require $base . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

$markers = [
    '.WelcomeNote'          => 'WelcomeNote',
    '.CheckEnvironment'     => 'CheckEnvironment',
    '.LicenseVerification'  => 'LicenseVerification',
    '.DatabaseSetup'        => 'DatabaseSetup',
    '.AdminSetup'           => 'AdminSetup',
    '.Complete'             => 'Complete',
    '.app_installed'        => 'installed',
];

foreach ($markers as $file => $contents) {
    Storage::disk('local')->put($file, $contents);
    echo "created storage/app/{$file}\n";
}

if (! Schema::hasTable('users')) {
    echo "\nWARNING: users table missing. Run: php artisan app:setup\n";
    exit(1);
}

$userCount = \App\Models\User::count();
echo "\nOK: install markers set. users in database: {$userCount}\n";
echo "Open: " . rtrim(config('app.url'), '/') . "/login\n";

exit(0);
