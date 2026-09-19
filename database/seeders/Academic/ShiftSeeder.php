<?php

namespace Database\Seeders\Academic;

use App\Models\Academic\Shift;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Shift::create([
            'name' => '1st'
        ]);
        Shift::create([
            'name' => '2nd'
        ]);
        Shift::create([
            'name' => '3rd'
        ]);
    }
}
