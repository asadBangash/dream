<?php

namespace Database\Seeders\Accounts;

use App\Models\Accounts\Income;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Income::create([
            'session_id'     => setting('session'),
            'name'           => 'School Donation',
            'income_head'    => 2,
            'date'           => date('Y-m-d'),
            'invoice_number' => 466466,
            'amount'         => 852
        ]);
        Income::create([
            'session_id'     => setting('session'),
            'name'           => 'School Rent',
            'income_head'    => 3,
            'date'           => date('Y-m-d'),
            'invoice_number' => 446479,
            'amount'         => 741
        ]);
        Income::create([
            'session_id'     => setting('session'),
            'name'           => 'School Book Sale	',
            'income_head'    => 4,
            'date'           => date('Y-m-d'),
            'invoice_number' => 332312,
            'amount'         => 963
        ]);
    }
}
