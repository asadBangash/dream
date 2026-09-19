<?php

namespace Database\Seeders\Accounts;

use App\Models\Accounts\Expense;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Expense::create([
            'session_id'     => setting('session'),
            'name'           => 'School Stationery Purchase',
            'expense_head'   => 4,
            'date'           => date('Y-m-d'),
            'invoice_number' => 466766,
            'amount'         => 800
        ]);
        Expense::create([
            'session_id'     => setting('session'),
            'name'           => 'School Eectricity Bill',
            'expense_head'   => 5,
            'date'           => date('Y-m-d'),
            'invoice_number' => 445479,
            'amount'         => 580
        ]);
        Expense::create([
            'session_id'     => setting('session'),
            'name'           => 'School Telephone Bill',
            'expense_head'   => 6,
            'date'           => date('Y-m-d'),
            'invoice_number' => 342312,
            'amount'         => 690
        ]);
    }
}
