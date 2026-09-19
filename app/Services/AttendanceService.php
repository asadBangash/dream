<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Session;
use App\Enums\AttendanceType;
use App\Models\Attendance\Attendance;


class AttendanceService
{
    public function monthlyAttendance()
    {
        try {
            $sessionClassStudent = sessionClassStudent();

            if (request()->filled('month') && strtolower(request('month')) != 'null') {
                $requestedMonth = date('Y') . '-' . request('month');
                list($requestedYear, $requestedMonth) = explode('-', $requestedMonth);
                $currentDate = Carbon::createFromDate($requestedYear, $requestedMonth, 1);
            } else {
                $currentDate = Carbon::now();
            }

            $totalDaysInCurrentMonth    = $currentDate->daysInMonth;
            $attendances                = [];
            $totalPresent               = 0;
            $totalAbsent                = 0;
            $totalLate                  = 0;
            $totalHalfDay               = 0;
            $totalHoliday               = 0;

            for ($day = 1; $day <= $totalDaysInCurrentMonth; $day++) {

                $date           = $currentDate->copy()->day($day);

                $attendance     = Attendance::query()
                                ->where('session_id', $sessionClassStudent->session_id)
                                ->where('classes_id', $sessionClassStudent->classes_id)
                                ->where('section_id', $sessionClassStudent->section_id)
                                ->whereHas('student', fn ($q) => $q->where('id', @sessionClassStudent()->student_id))
                                ->where('date', date('Y-m-d', strtotime($date->toDateString())))
                                ->first();

                $status         = ___('common.N/A');
                $colorCode      = "0xFFFDBB27";

                if ($attendance) {
                    if ($attendance->attendance == AttendanceType::PRESENT) {

                        $status     = ___('common.Present');
                        $colorCode  = "0xFF46D4FF";
                        $totalPresent++;

                    } elseif ($attendance->attendance == AttendanceType::LATE) {

                        $status     = ___('common.Late');
                        $colorCode  = "0xFFFFB657";
                        $totalLate++;

                    } elseif ($attendance->attendance == AttendanceType::ABSENT) {

                        $status     = ___('common.Absent');
                        $colorCode  = "0xFFFF5170";
                        $totalAbsent++;

                    } elseif ($attendance->attendance == AttendanceType::HALFDAY) {

                        $status     = ___('common.Half-Day');
                        $colorCode  = "0xFFF969F8";
                        $totalHalfDay++;

                    } else {

                        $status     = ___('common.Holiday');
                        $colorCode  = "0xFFFDBB27";
                        $totalHoliday++;
                    }
                }

                $attendances[]  = [
                    'day'               => (int) $date->format('d'),
                    'day_name'          => $date->format('l'),
                    'date'              => $date->format('Y-m-d'),
                    'status'            => $status,
                    'color_code'        => $colorCode,
                    'note'              => @$attendance->note,
                ];
            }

            $countings = [
                'presents'      => $totalPresent,
                'absents'       => $totalAbsent,
                'lates'         => $totalLate,
                'half_days'     => $totalHalfDay,
                'holidays'      => $totalHoliday,
                'not_available' => $totalDaysInCurrentMonth - ($totalPresent + $totalAbsent + $totalLate + $totalHalfDay + $totalHoliday),
            ];

            $data = [
                'countings'     => $countings,
                'attendances'   => $attendances
            ];

            return $data;

        } catch (\Throwable $th) {
            return [];
        }
    }


    public function attendanceProgress()
    {
        $sessionClassStudent = sessionClassStudent();
        $session = Session::where('id', @$sessionClassStudent->session_id)->first();

        if (request()->filled('month') && strtolower(request('month')) != 'null') {
            $month      = Carbon::createFromFormat('Y-m', date('Y') . '-' .  request('month'))->startOfMonth();
            $startDate  = Carbon::parse($month->startOfMonth());
            $endDate    = Carbon::parse($month->endOfMonth());
        } else {
            $startDate  = Carbon::parse($session->start_date);
            $endDate    = Carbon::now();
        }

        $dates      = Carbon::parse($startDate)->daysUntil($endDate);
        $dates      = collect($dates)->map(function ($date) {
                        return $date->format('Y-m-d');
                    });

        $totalNotAvailable  = 0;
        $totalPresent       = 0;
        $totalAbsent        = 0;
        $totalLate          = 0;
        $totalHalfDay       = 0;
        $totalHoliday       = 0;
        
        foreach ($dates ?? [] as $date) {
            $attendance     = Attendance::query()
                            ->where('session_id', $sessionClassStudent->session_id)
                            ->where('classes_id', $sessionClassStudent->classes_id)
                            ->where('section_id', $sessionClassStudent->section_id)
                            ->whereHas('student', fn ($q) => $q->where('id', @sessionClassStudent()->student_id))
                            ->where('date', $date)
                            ->first();

            if ($attendance) {
                if ($attendance->attendance == AttendanceType::PRESENT) {
                    $totalPresent++;
                } elseif ($attendance->attendance == AttendanceType::LATE) {
                    $totalLate++;
                } elseif ($attendance->attendance == AttendanceType::ABSENT) {
                    $totalAbsent++;
                } elseif ($attendance->attendance == AttendanceType::HALFDAY) {
                    $totalHalfDay++;
                } else {
                    $totalHoliday++;
                }
            } else {
                $totalNotAvailable++;
            }
        }

        $totalDays                  = count($dates);
        $presentPercentage          = number_format(($totalPresent / $totalDays) * 100, 2);
        $latePercentage             = number_format(($totalLate / $totalDays) * 100, 2);
        $absentPercentage           = number_format(($totalAbsent / $totalDays) * 100, 2);
        $halfDayPercentage          = number_format(($totalHalfDay / $totalDays) * 100, 2);
        $holidayPercentage          = number_format(($totalHoliday / $totalDays) * 100, 2);
        $notAvailablePercentage     = number_format(($totalNotAvailable / $totalDays) * 100, 2);

        return [
            [
                'title'         => ___('common.Present'),
                'percentage'    => (float) $presentPercentage,
                'color_code'    => '0xFF46D4FF'
            ],
            [
                'title'         => ___('common.Late'),
                'percentage'    => (float) $latePercentage,
                'color_code'    => '0xFFFFB657'
            ],
            [
                'title'         => ___('common.Absent'),
                'percentage'    => (float) $absentPercentage,
                'color_code'    => '0xFFFF5170'
            ],
            [
                'title'         => ___('common.Half-Day'),
                'percentage'    => (float) $halfDayPercentage,
                'color_code'    => '0xFFF969F8'
            ],
            [
                'title'         => ___('common.Holiday'),
                'percentage'    => (float) $holidayPercentage,
                'color_code'    => '0xFFFDBB27'
            ],
            [
                'title'         => ___('common.Not Available'),
                'percentage'    => (float) $notAvailablePercentage,
                'color_code'    => '0xFFFDBB27'
            ],
        ];
    }


    public function yearlyPresentPercentage()
    {
        $data = [];
        $year = request()->filled('year') && strtolower(request('year') != 'null') ? request('year') : date('Y');

        $months = [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        ];

        $sessionClassStudent = sessionClassStudent();

        foreach ($months ?? [] as $monthNo => $monthName) {

            $month      = Carbon::createFromFormat('Y-m', $year . '-' . $monthNo);
            $startDate  = Carbon::parse($month->startOfMonth());
            $endDate    = Carbon::parse($month->endOfMonth());
            $dates      = Carbon::parse($startDate)->daysUntil($endDate);
            $dates      = collect($dates)->map(function ($date) {
                            return $date->format('Y-m-d');
                        });
                        
            $totalPresent = 0;

            foreach ($dates ?? [] as $date) {
                $attendance     = Attendance::query()
                                ->where('session_id', $sessionClassStudent->session_id)
                                ->where('classes_id', $sessionClassStudent->classes_id)
                                ->where('section_id', $sessionClassStudent->section_id)
                                ->whereHas('student', fn ($q) => $q->where('id', @sessionClassStudent()->student_id))
                                ->where('date', $date)
                                ->first();
    
                if ($attendance && @$attendance->attendance == AttendanceType::PRESENT) {
                    $totalPresent++;
                }
            }

            $totalDays                  = count($dates);
            $presentPercentage          = number_format(($totalPresent / $totalDays) * 100, 2);

            $data[] = [
                'month'                 => $monthName,
                'present_percentage'    => (float) $presentPercentage
            ];
        }

        return $data;
    }
}
