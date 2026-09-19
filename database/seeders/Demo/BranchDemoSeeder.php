<?php

namespace Database\Seeders\Demo;

use App\Enums\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchDemoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('branches')->where('id', 1)->update([
            'name'       => DemoContext::BOYS_BRANCH_NAME,
            'phone'      => '+92 91 5201234',
            'email'      => 'boys@dreamtuition.pk',
            'address'    => 'University Road, Peshawar, Khyber Pakhtunkhwa, Pakistan',
            'status'     => Status::ACTIVE,
            'updated_at' => now(),
        ]);

        DemoContext::$boysBranchId = 1;

        $girlsExists = DB::table('branches')->where('name', DemoContext::GIRLS_BRANCH_NAME)->value('id');

        if ($girlsExists) {
            DemoContext::$girlsBranchId = (int) $girlsExists;
        } else {
            DemoContext::$girlsBranchId = (int) DB::table('branches')->insertGetId([
                'name'       => DemoContext::GIRLS_BRANCH_NAME,
                'phone'      => '+92 91 5205678',
                'email'      => 'girls@dreamtuition.pk',
                'address'    => 'Saddar Road, Peshawar, Khyber Pakhtunkhwa, Pakistan',
                'lat'        => '34.0151',
                'long'       => '71.5249',
                'status'     => Status::ACTIVE,
                'country_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DemoContext::$branchSlugs = [
            DemoContext::$boysBranchId  => 'boys',
            DemoContext::$girlsBranchId => 'girls',
        ];
    }
}
