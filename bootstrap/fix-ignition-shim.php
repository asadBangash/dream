<?php

/**
 * Ensures legacy Ignition class exists (incomplete spatie/error-solutions extracts).
 */
$source = __DIR__ . '/spatie-ignition-shims/IncorrectValetDbCredentialsSolutionProvider.php';
$target = dirname(__DIR__) . '/vendor/spatie/error-solutions/legacy/laravel-ignition/Solutions/SolutionProviders/IncorrectValetDbCredentialsSolutionProvider.php';

if (! is_file($source) || is_file($target)) {
    return;
}

$dir = dirname($target);
if (! is_dir($dir)) {
    mkdir($dir, 0777, true);
}

copy($source, $target);
