<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         LeaveType::create([
            'name' => 'Student Sick Leave',
            'short_desc' => 'Student Sick Leave Type',
            'role_id' => 6,
            'active_status'=> 1
        ]);

        LeaveType::create([
            'name' => 'Emergency Leave',
            'short_desc' => 'Student Sick Leave Type',
            'role_id' => 6,
            'active_status'=> 1
        ]);
    }
}
