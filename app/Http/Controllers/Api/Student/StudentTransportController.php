<?php

namespace App\Http\Controllers\Api\Student;

use Illuminate\Http\Request;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\Student\LiveTrackResource;
use App\Http\Resources\Student\DutyScheduleCollection;
use App\Http\Requests\StudentPanel\StudentFeedbackRequest;
use App\Http\Resources\Student\EnrollmentReportCollection;
use App\Repositories\StudentPanel\StudentTransportRepository;

class StudentTransportController extends Controller
{
    use ReturnFormatTrait;

    protected $repository;

    public function __construct(StudentTransportRepository $repository)
    {
        $this->repository = $repository;
    }

    public function dutySchedule(Request $request)
    {
        try {
            $dutySchedules = $this->repository->dutySchedule($request);

            $dutySchedules = new DutyScheduleCollection($dutySchedules);

            return $this->responseWithSuccess(___('vehicle_tracker.Duty schedule list'), $dutySchedules);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function enrollmentReport(Request $request)
    {
        try {
            $enrollmentReport = $this->repository->enrollmentReport($request);

            $enrollmentReport = new EnrollmentReportCollection($enrollmentReport);

            return $this->responseWithSuccess(___('vehicle_tracker.Enrollment report'), $enrollmentReport);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function liveTrack()
    {
        try {
            $liveTrack = $this->repository->liveTrack();

            $liveTrack = new LiveTrackResource($liveTrack);

            return $this->responseWithSuccess(___('vehicle_tracker.Live track data'), $liveTrack);
        } catch (\Exception $th) {
            return $this->responseWithError($th->getMessage(), []);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function feedback(StudentFeedbackRequest $request)
    {
        try {
            $feedback = $this->repository->feedback($request);

            return $this->responseWithSuccess(___('vehicle_tracker.Student feedback successfully done'), $feedback);
        } catch (\Exception $exception) {

            return $this->responseWithError($exception->getMessage(), []);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }
}
