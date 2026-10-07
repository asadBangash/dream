<?php

namespace Database\Seeders;

use Database\Seeders\Demo\BranchDemoSeeder;
use Database\Seeders\Demo\DemoUserSeeder;
use Illuminate\Database\Seeder;

/**
 * Optional QA seed: php artisan db:seed --class=BranchIsolationTestSeeder
 * Creates Boys/Girls branches + 3 demo admins (not for production).
 */
class BranchIsolationTestSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            BranchDemoSeeder::class,
            DemoUserSeeder::class,
        ]);
    }
}
