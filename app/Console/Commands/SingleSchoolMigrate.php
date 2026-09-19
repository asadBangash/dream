<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class SingleSchoolMigrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'single:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Artisan::call('db:wipe', ['--force' => true, '-vvv' => true]);
        $migrationPaths = $this->tenantMigrationPaths();

        foreach ($migrationPaths as $path) {
            $this->customStyleText('Migrating: ' . $path . ' ...', '#0a0a0a', '#effcb1');

            try {
                Artisan::call('migrate', ['--path' => $path, '--force' => true, '-vvv' => true]);

                $this->info(Artisan::output());
            } catch (\Exception $e) {
                $this->customStyleText("An error occurred while migrating: " . $e->getMessage() . ' ...', '#0a0a0a', '#ff9191');
            }
        }
        Artisan::call('db:seed', ['--force' => true]);

        $this->info(Artisan::output());
        $this->info('Database has been successfully migrated');
    }





    function customStyleText($text, $textColorHex, $bgColorHex)
    {
        $output = new ConsoleOutput();
        $style = new OutputFormatterStyle($textColorHex, $bgColorHex);
        $output->getFormatter()->setStyle('custom-style', $style);
        $output->writeln('<custom-style>' . $text . '</>');
        $output->getFormatter()->setStyle('custom-style', new OutputFormatterStyle());
    }


    function tenantMigrationPaths()
    {
        $filePath = base_path('modules_statuses.json');

        $migrationPaths = [
            'database/migrations/tenant'
        ];

        if (file_exists($filePath)) {
            $json_content = file_get_contents($filePath);
            $modules = json_decode($json_content, true);
            unset($modules["MainApp"]);

            foreach ($modules as $module => $status) {
                if ($status === true) {
                    $migrationPaths[] = "Modules/$module/Database/Migrations";
                }
            }
        }

        return $migrationPaths;
    }
}
