<?php

namespace App\View\Composers;

use App\Repositories\Attendance\AttendanceRepository;
use Illuminate\View\View;

class AttendanceComposer
{
    /**
     * The user Interface implementation.
     *
     * @var \App\Interfaces\AttendanceRepository
     */
    protected $attendance;

    /**
     * Create a new profile composer.
     *
     * @param  \App\Repositories\AttendanceRepository  $language
     * @return void
     */
    public function __construct(AttendanceRepository $attendance)
    {
        $this->attendance = $attendance;
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $attendance = $this->attendance->attendance();

        $view->with('attendance', $attendance);
    }
}
