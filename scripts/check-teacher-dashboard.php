<?php

/**
 * SSH/local: php scripts/check-teacher-dashboard.php
 * Verifies DB + files needed for /teacher-dashboard
 */

$base = dirname(__DIR__);
require $base . '/vendor/autoload.php';
$app = require $base . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Schema;

echo "=== Teacher panel checks ===\n\n";

$files = [
    'app/Http/Controllers/Backend/TeacherDashboardController.php',
    'app/Repositories/TeacherDashboardRepository.php',
    'resources/views/backend/teacher-dashboard.blade.php',
];

foreach ($files as $file) {
    $ok = is_file($base . '/' . $file);
    echo ($ok ? 'OK' : 'MISSING') . "  {$file}\n";
}

echo "\nDatabase:\n";
echo '  teacher_lectures table: ' . (Schema::hasTable('teacher_lectures') ? "yes\n" : "NO — run tenant migrations\n");
echo '  homeworks table: ' . (Schema::hasTable('homeworks') ? "yes\n" : "NO\n");
echo '  events table: ' . (Schema::hasTable('events') ? "yes\n" : "NO\n");

if (Schema::hasTable('migrations')) {
    $ran = Illuminate\Support\Facades\DB::table('migrations')
        ->where('migration', 'like', '%teacher_lectures%')
        ->exists();
    echo '  migration teacher_lectures recorded: ' . ($ran ? "yes\n" : "NO\n");
}

echo "\nIf table is missing on live:\n";
echo "  php artisan migrate --path=database/migrations/tenant --force\n";
echo "  (SaaS) php artisan tenants:migrate\n";
echo "\nRead the real error:\n";
echo "  tail -50 storage/logs/laravel-" . date('Y-m-d') . ".log\n";
