<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchBootstrapSeeder extends Seeder
{
    public function run(): void
    {
        if (! hasModule('MultiBranch')) {
            return;
        }

        DB::table('branches')->where('id', 1)->update([
            'name'       => env('DEFAULT_BRANCH_NAME', 'Main Campus'),
            'phone'      => env('DEFAULT_BRANCH_PHONE', '+92 91 0000000'),
            'email'      => env('DEFAULT_BRANCH_EMAIL', 'main@' . env('APP_DOMAIN', 'school.local')),
            'address'    => env('DEFAULT_BRANCH_ADDRESS', 'Peshawar, Pakistan'),
            'updated_at' => now(),
        ]);
    }
}
