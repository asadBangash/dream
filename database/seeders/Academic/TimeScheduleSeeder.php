<?php

namespace Database\Seeders\Academic;

use App\Models\Academic\TimeSchedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimeScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TimeSchedule::create([
            'type'       => '1',
            'start_time' => '09:00',
            'end_time'   => '09:59',
        ]);
        TimeSchedule::create([
            'type'       => '1',
            'start_time' => '10:00',
            'end_time'   => '10:59',
        ]);
        TimeSchedule::create([
            'type'       => '1',
            'start_time' => '11:00',
            'end_time'   => '11:59',
        ]);
        TimeSchedule::create([
            'type'       => '1',
            'start_time' => '12:00',
            'end_time'   => '12:59',
        ]);
        TimeSchedule::create([
            'type'       => '1',
            'start_time' => '1:00',
            'end_time'   => '1:59',
        ]);
        TimeSchedule::create([
            'type'       => '1',
            'start_time' => '2:00',
            'end_time'   => '2:59',
        ]);
        TimeSchedule::create([
            'type'       => '1',
            'start_time' => '3:00',
            'end_time'   => '3:59',
        ]);
        TimeSchedule::create([
            'type'       => '1',
            'start_time' => '4:00',
            'end_time'   => '4:59',
        ]);
        TimeSchedule::create([
            'type'       => '1',
            'start_time' => '5:00',
            'end_time'   => '5:59',
        ]);
        TimeSchedule::create([
            'type'       => '1',
            'start_time' => '6:00',
            'end_time'   => '6:59',
        ]);
        TimeSchedule::create([
            'type'       => '1',
            'start_time' => '7:00',
            'end_time'   => '7:59',
        ]);
        TimeSchedule::create([
            'type'       => '1',
            'start_time' => '8:00',
            'end_time'   => '8:59',
        ]);
        TimeSchedule::create([
            'type'       => '2',
            'start_time' => '09:00',
            'end_time'   => '09:59',
        ]);
        TimeSchedule::create([
            'type'       => '2',
            'start_time' => '10:00',
            'end_time'   => '10:59',
        ]);
        TimeSchedule::create([
            'type'       => '2',
            'start_time' => '11:00',
            'end_time'   => '11:59',
        ]);
        TimeSchedule::create([
            'type'       => '2',
            'start_time' => '12:00',
            'end_time'   => '12:59',
        ]);
        TimeSchedule::create([
            'type'       => '2',
            'start_time' => '1:00',
            'end_time'   => '1:59',
        ]);
        TimeSchedule::create([
            'type'       => '2',
            'start_time' => '2:00',
            'end_time'   => '2:59',
        ]);
        TimeSchedule::create([
            'type'       => '2',
            'start_time' => '3:00',
            'end_time'   => '3:59',
        ]);
        TimeSchedule::create([
            'type'       => '2',
            'start_time' => '4:00',
            'end_time'   => '4:59',
        ]);
        TimeSchedule::create([
            'type'       => '2',
            'start_time' => '5:00',
            'end_time'   => '5:59',
        ]);
        TimeSchedule::create([
            'type'       => '2',
            'start_time' => '6:00',
            'end_time'   => '6:59',
        ]);
        TimeSchedule::create([
            'type'       => '2',
            'start_time' => '7:00',
            'end_time'   => '7:59',
        ]);
        TimeSchedule::create([
            'type'       => '2',
            'start_time' => '8:00',
            'end_time'   => '8:59',
        ]);
    }
}
