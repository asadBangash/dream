<?php

namespace Database\Seeders\StudentInfo;

use App\Models\StudentInfo\ParentGuardian;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ParentGuardianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <= 10; $i++) { 
            $user = User::create([
                'name'              => 'Guardian'.$i,
                'phone'             => '1236585'.$i,
                'email'             => 'guardian'.$i.'@gmail.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('123456'),
                'role_id'           => 7,
                'permissions'       => []
            ]);
            ParentGuardian::create([
                'user_id'             => $user->id,
                'father_name'         => 'Father'.$i,
                'father_mobile'       => '1236585'.$i,
                'father_profession'   => 'Teacher',
                'mother_name'         => 'Mother',
                'mother_mobile'       => '0147892'.$i,
                'mother_profession'   => 'Teacher',
                'guardian_name'       => 'Guardian'.$i,
                'guardian_email'      => 'guardian'.$i.'@gmail.com',
                'guardian_mobile'     => '1236585'.$i,
                'guardian_profession' => 'Teacher',
                'guardian_relation'   => 'Father',
                'guardian_address'    => 'Dhaka'
            ]);
        }
    }
}
