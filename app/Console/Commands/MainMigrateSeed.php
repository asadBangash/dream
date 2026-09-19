<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;

class MainMigrateSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:main-seed';

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

        Log::info('Command is running');

        Artisan::call('migrate:fresh', [
            '--path' => 'modules/MainApp/database/migrations',
        ]);

        $output = Artisan::output();

        Log::info('Migrate: ' . $output);

        return Command::SUCCESS;
    }
}
