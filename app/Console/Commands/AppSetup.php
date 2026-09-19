<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class AppSetup extends Command
{
    protected $signature = 'app:setup {--fresh : Drop all tables before migrating}';

    protected $description = 'Run migrations and essential seeders for a fresh or existing database';

    public function handle(): int
    {
        if ($this->option('fresh')) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            Artisan::call('db:wipe', ['--force' => true]);
            $this->info('Database wiped.');
        }

        foreach ($this->migrationPaths() as $path) {
            $this->info("Migrating: {$path}");
            Artisan::call('migrate', ['--path' => $path, '--force' => true]);
            $this->line(trim(Artisan::output()));
        }

        Artisan::call('db:seed', ['--force' => true]);
        $this->line(trim(Artisan::output()));
        $this->info('Application setup completed.');

        return self::SUCCESS;
    }

    private function migrationPaths(): array
    {
        $paths = ['database/migrations/tenant'];
        $modulesFile = base_path('modules_statuses.json');

        if (! file_exists($modulesFile)) {
            return $paths;
        }

        $modules = json_decode(file_get_contents($modulesFile), true) ?? [];

        unset($modules['MainApp'], $modules['Installer']);

        foreach ($modules as $module => $enabled) {
            if ($enabled && is_dir(base_path("Modules/{$module}/Database/Migrations"))) {
                $paths[] = "Modules/{$module}/Database/Migrations";
            }
        }

        return $paths;
    }
}
