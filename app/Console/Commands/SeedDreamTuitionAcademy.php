<?php

namespace App\Console\Commands;

use Database\Seeders\DreamTuitionAcademySeeder;
use Illuminate\Console\Command;

class SeedDreamTuitionAcademy extends Command
{
    protected $signature = 'academy:seed-dream {--teachers-only : Seed teachers only}';

    protected $description = 'Seed Dream Tuition Academy structure and/or teachers';

    public function handle(): int
    {
        if ($this->option('teachers-only')) {
            $this->call('db:seed', [
                '--class' => \Database\Seeders\DreamTuitionTeachersSeeder::class,
                '--force' => true,
            ]);

            return self::SUCCESS;
        }

        $this->call('db:seed', [
            '--class' => DreamTuitionAcademySeeder::class,
            '--force' => true,
        ]);

        $this->call('db:seed', [
            '--class' => \Database\Seeders\DreamTuitionTeachersSeeder::class,
            '--force' => true,
        ]);

        return self::SUCCESS;
    }
}
