<?php

namespace Database\Seeders\Fees;

use App\Models\Fees\FeesType;
use App\Models\Fees\FeesMaster;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FeesMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fees_types = FeesType::all();

        foreach ($fees_types as $fees_type) {

            FeesMaster::create([
                'session_id'          => setting('session'),
                'fees_group_id'       => $fees_type->id <=5 ? 1:2,
                'fees_type_id'        => $fees_type->id,
                'due_date'            => date('Y-m-d'),
                'amount'              => 1000,
                'fine_type'           => 0
            ]);

            
        }
    }
}
