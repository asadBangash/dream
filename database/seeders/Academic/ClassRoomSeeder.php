<?php

namespace Database\Seeders\Academic;

use App\Models\Academic\ClassRoom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClassRoom::create([
            'room_no'  => '101',
            'capacity' => '50'
        ]);
        ClassRoom::create([
            'room_no'  => '102',
            'capacity' => '60'
        ]);
        ClassRoom::create([
            'room_no'  => '103',
            'capacity' => '40'
        ]);
        ClassRoom::create([
            'room_no'  => '104',
            'capacity' => '50'
        ]);
        ClassRoom::create([
            'room_no'  => '105',
            'capacity' => '50'
        ]);
        ClassRoom::create([
            'room_no'  => '106',
            'capacity' => '50'
        ]);
        ClassRoom::create([
            'room_no'  => '107',
            'capacity' => '50'
        ]);
        ClassRoom::create([
            'room_no'  => '108',
            'capacity' => '50'
        ]);
        ClassRoom::create([
            'room_no'  => '109',
            'capacity' => '50'
        ]);
        ClassRoom::create([
            'room_no'  => '110',
            'capacity' => '50'
        ]);
        ClassRoom::create([
            'room_no'  => '111',
            'capacity' => '50'
        ]);
        ClassRoom::create([
            'room_no'  => '112',
            'capacity' => '50'
        ]);
        ClassRoom::create([
            'room_no'  => '113',
            'capacity' => '50'
        ]);
    }
}
