<?php

namespace App\Http\Controllers\Api\Student;

use App\Models\Slider;
use App\Traits\ReturnFormatTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\SliderResource;

class HomeAPIController extends Controller
{
    use ReturnFormatTrait;

    public function __invoke()
    {
        try {
            $data['sliders']    = SliderResource::collection(Slider::where('status', 1)->orderBy('serial', 'ASC')->get());
            $data['menus']      = $this->menus();

            return $this->responseWithSuccess(___('alert.success'), $data);

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), $th->getMessage());
        }
    }

    protected function menus()
    {
        return [
            [
                "id"    => 1,
                "name"  => "Subject",
                "slug"  => "subject",
                "icon"  => asset('images/student/menu-icon/subject.png')
            ],
            [
                "id"    => 2,
                "name"  => "Class Routine",
                "slug"  => "class-routine",
                "icon"  => asset('images/student/menu-icon/class-routine.png')
            ],
            [
                "id"    => 3,
                "name"  => "Exam Routine",
                "slug"  => "exam-routine",
                "icon"  => asset('images/student/menu-icon/exam-routine.png')
            ],
            [
                "id"    => 4,
                "name"  => "Marksheet",
                "slug"  => "marksheet",
                "icon"  => asset('images/student/menu-icon/marksheet.png')
            ],
            [
                "id"    => 5,
                "name"  => "Attendance",
                "slug"  => "attendance",
                "icon"  => asset('images/student/menu-icon/attendance.png')
            ],
            [
                "id"    => 6,
                "name"  => "Fees",
                "slug"  => "fees",
                "icon"  => asset('images/student/menu-icon/fees.png')
            ],
            [
                "id"    => 7,
                "name"  => "Online Exam",
                "slug"  => "online-exam",
                "icon"  => asset('images/student/menu-icon/online-exam.png')
            ],
            [
                "id"    => 8,
                "name"  => "Student Info",
                "slug"  => "student-info",
                "icon"  => asset('images/student/menu-icon/student-info.png')
            ],
            [
                "id"    => 9,
                "name"  => "Events",
                "slug"  => "events",
                "icon"  => asset('images/student/menu-icon/class-routine.png')
            ],
            [
                "id"    => 10,
                "name"  => "Student Homework",
                "slug"  => "student-homework",
                "icon"  => asset('images/student/menu-icon/online-exam.png')
            ],
            [
                "id"    => 11,
                "name"  => "Library",
                "slug"  => "student-library",
                "icon"  => asset('images/student/menu-icon/subject.png')
            ],
        ];
    }
}
