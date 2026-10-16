<?php

namespace App\Console\Commands;

use Database\Seeders\DreamTuitionFeesSeeder;
use Illuminate\Console\Command;

class SeedDreamTuitionFees extends Command
{
    protected $signature = 'academy:seed-fees';

    protected $description = 'Seed fee groups, types, masters (2026), and assigns for enrolled students';

    public function handle(): int
    {
        $this->call('db:seed', [
            '--class' => DreamTuitionFeesSeeder::class,
            '--force' => true,
        ]);

        return self::SUCCESS;
    }
}
