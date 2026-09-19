<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Facades\File;

class ModuleInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
    */
    protected $signature = 'module:install {module}';

    /**
     * The console command description.
     *
     * @var string
    */
    protected $description = 'Active then run migrations and seeds for a specific module';

    /**
     * Execute the console command.
     *
     * @return int
    */
    public function handle()
    {
        $moduleName = $this->argument('module');
        $module     = Module::find($moduleName);

        if (!$module) {
            $this->error("Module '$moduleName' not found.");
            return Command::FAILURE;
        }

        // Check if the module is inactive
        if (!$module->isEnabled()) {
            $this->info("Module '$moduleName' is currently inactive. Activating it...");
            $module->enable();
            $this->info("Module '$moduleName' activated successfully.");
        }

        // Get the module's migrations path
        $migrationsPath = module_path($moduleName, 'Database/Migrations');
        $pendingMigrations = [];

        if (is_dir($migrationsPath)) {
            // Get list of migration files
            $migrationFiles = File::files($migrationsPath);

            foreach ($migrationFiles as $file) {
                $migrationName = pathinfo($file->getFilename(), PATHINFO_FILENAME);

                // Check if migration has already been executed
                $exists = DB::table('migrations')
                ->where('migration', $migrationName)
                ->exists();

                if (!$exists) {
                    $pendingMigrations[] = $file->getFilename();
                }
            }

            if (empty($pendingMigrations)) {
                $this->info("All migrations for module '$moduleName' have already been executed. Skipping migrations.");
            } else {
                // Run migrations
                $this->info("Running pending migrations for module: $moduleName");
                $this->call('module:migrate', ['module' => $moduleName]);

                // Run Seeders
                if (env('APP_DEMO')) {
                    $this->info("Running seeders for module: $moduleName");
                    $this->call('db:seed', ['--class' => "Modules\\{$moduleName}\\Database\\Seeders\\{$moduleName}DatabaseSeeder"]);
                }
            }
        } else {
            $this->info("No migrations found for module: $moduleName");
        }

        $this->info("Migrations and seeds for module '$moduleName' completed.");

        return Command::SUCCESS;
    }
}
