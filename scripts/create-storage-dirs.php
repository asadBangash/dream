<?php

/**
 * Shared-hosting helper: create writable storage directories without Artisan,
 * symlinks, exec(), or proc_open().
 *
 * Usage (SSH):
 *   php scripts/create-storage-dirs.php
 *
 * Or open once in browser (delete this file after use):
 *   https://yourdomain.com/../scripts/create-storage-dirs.php?token=YOUR_TOKEN
 */

$isCli = PHP_SAPI === 'cli';

if (!$isCli) {
    $token = $_GET['token'] ?? '';
    if ($token === '' || !hash_equals(getenv('SETUP_TOKEN') ?: 'change-me-before-run', $token)) {
        http_response_code(403);
        exit('Forbidden');
    }
}

$base = dirname(__DIR__);

$directories = [
    $base . '/storage/app/public',
    $base . '/storage/app/public/marksheets',
    $base . '/storage/app/public/progress_card',
    $base . '/storage/app/public/attendance_report',
    $base . '/storage/app/public/uploads',
    $base . '/storage/framework/cache/data',
    $base . '/storage/framework/sessions',
    $base . '/storage/framework/views',
    $base . '/storage/logs',
    $base . '/bootstrap/cache',
    $base . '/public/storage',
    $base . '/public/storage/marksheets',
    $base . '/public/storage/progress_card',
    $base . '/public/storage/attendance_report',
    $base . '/public/storage/uploads',
    $base . '/public/backend/uploads',
    $base . '/public/backend/uploads/settings',
    $base . '/public/backend/uploads/users',
];

$results = [];

foreach ($directories as $dir) {
    if (is_dir($dir)) {
        $results[] = "exists:  {$dir}";
        continue;
    }

    if (@mkdir($dir, 0755, true)) {
        $results[] = "created: {$dir}";
    } else {
        $results[] = "FAILED:  {$dir}";
    }
}

$output = implode(PHP_EOL, $results) . PHP_EOL;

if ($isCli) {
    echo $output;
    exit(0);
}

header('Content-Type: text/plain');
echo $output;
