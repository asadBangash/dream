<?php

namespace Database\Seeders\Academic;

use App\Models\Academic\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subject::create([
            'name' => 'Bangla',
            'code' => '101',
            'type' => '1',
        ]);
        Subject::create([
            'name' => 'English',
            'code' => '102',
            'type' => '1',
        ]);
        Subject::create([
            'name' => 'Math',
            'code' => '103',
            'type' => '1',
        ]);
        Subject::create([
            'name' => 'Physics',
            'code' => '104',
            'type' => '2',
        ]);
        Subject::create([
            'name' => 'Chemistry',
            'code' => '105',
            'type' => '2',
        ]);
        Subject::create([
            'name' => 'Biology',
            'code' => '106',
            'type' => '2',
        ]);
        Subject::create([
            'name' => 'Higher Math',
            'code' => '107',
            'type' => '2',
        ]);
        Subject::create([
            'name' => 'Information & Technology',
            'code' => '108',
            'type' => '2',
        ]);
        Subject::create([
            'name' => 'Islam & Moral Education',
            'code' => '109',
            'type' => '2',
        ]);
        Subject::create([
            'name' => 'Bangladesh & World',
            'code' => '110',
            'type' => '2',
        ]);
        Subject::create([
            'name' => 'Agriculture Studies',
            'code' => '111',
            'type' => '2',
        ]);
        Subject::create([
            'name' => 'Home Science',
            'code' => '112',
            'type' => '2',
        ]);
        Subject::create([
            'name' => 'Accounting',
            'code' => '113',
            'type' => '2',
        ]);
    }
}
