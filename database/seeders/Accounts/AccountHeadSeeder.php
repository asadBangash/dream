<?php

namespace Database\Seeders\Accounts;

use App\Models\Accounts\AccountHead;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountHeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AccountHead::create([ // default row. don't remove this.
            'name' => 'Fees',
            'type' => 1,
            'status' => 1
        ]);

        AccountHead::create([
            'name' => 'Donation',
            'type' => 1,
            'status' => 1
        ]);
        AccountHead::create([
            'name' => 'Rent',
            'type' => 1,
            'status' => 1
        ]);
        AccountHead::create([
            'name' => 'Book Sale',
            'type' => 1,
            'status' => 1
        ]);
        AccountHead::create([
            'name' => 'Stationery Purchase',
            'type' => 2,
            'status' => 1
        ]);
        AccountHead::create([
            'name' => 'Electricity Bill',
            'type' => 2,
            'status' => 1
        ]);
        AccountHead::create([
            'name' => 'Telephone Bill',
            'type' => 2,
            'status' => 1
        ]);
    }
}
