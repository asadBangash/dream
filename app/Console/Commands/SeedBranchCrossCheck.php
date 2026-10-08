<?php

namespace App\Console\Commands;

use Database\Seeders\TwoBranchCrossCheckSeeder;
use Illuminate\Console\Command;

class SeedBranchCrossCheck extends Command
{
    protected $signature = 'branch:seed-cross-check {--force : Confirm destructive reset of branch demo data}';

    protected $description = 'Replace all branches with Boys/Girls and one test student per branch';

    public function handle(): int
    {
        if (! $this->option('force')) {
            $this->error('This removes existing branches, students, and @example.com users in academic tables.');
            $this->line('Run: php artisan branch:seed-cross-check --force');

            return self::FAILURE;
        }

        $this->call('db:seed', ['--class' => TwoBranchCrossCheckSeeder::class, '--force' => true]);
        $this->newLine();
        $this->info('Run: php artisan demo:verify-branch-isolation');

        return self::SUCCESS;
    }
}
