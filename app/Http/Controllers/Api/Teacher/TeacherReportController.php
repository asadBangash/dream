<?php

namespace App\Http\Controllers\Api\Teacher;

use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Academic\Classes;
use App\Models\Academic\Section;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Models\Examination\ExamType;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\MeritlistResource;
use App\Repositories\Academic\ClassesRepository;
use App\Repositories\Report\MarksheetRepository;
use App\Repositories\Report\MeritListRepository;
use App\Repositories\Academic\ClassSetupRepository;
use App\Repositories\Report\ProgressCardRepository;
use App\Repositories\StudentInfo\StudentRepository;
use App\Repositories\Attendance\AttendanceRepository;

class TeacherReportController extends Controller
{
    use ReturnFormatTrait;
    private $repo;
    private $classRepo;
    private $classSetupRepo;
    private $studentRepo;
    private $meritListRepo;
    private $progressCardrepo;
    private $attendanceRepo;

    function __construct(
        MarksheetRepository    $repo,
        AttendanceRepository   $attendanceRepo,
        MeritListRepository    $meritListRepo,
        ClassesRepository      $classRepo,
        ClassSetupRepository   $classSetupRepo,
        StudentRepository      $studentRepo,
        ProgressCardRepository    $progressCardrepo,
    ) {
        $this->repo               = $repo;
        $this->attendanceRepo     = $attendanceRepo;
        $this->progressCardrepo   = $progressCardrepo;
        $this->classRepo          = $classRepo;
        $this->classSetupRepo     = $classSetupRepo;
        $this->studentRepo        = $studentRepo;
        $this->meritListRepo      = $meritListRepo;
        $this->progressCardrepo      = $progressCardrepo;
    }


    public function studentMarksheet(){

        if(!request(('student_id'))){
             return $this->responseWithError(___('alert.Student not found'), []);
        }
        if(!request(('exam_type_id'))){
             return $this->responseWithError(___('alert.Exam type not found'), []);
        }

        $request = new Request([
            'student'   => request('student_id'),
            'exam_type' => request('exam_type_id'),
            'class'     => request('class_id'),
            'section'   =>request('section_id'),
        ]);



        $data['class_sec'] = Classes::find($request->class)->name.'-'.Section::find($request->section)->name;
        $data['student']      = $this->studentRepo->show(request(('student_id')));
        $data['resultData']   = $this->repo->search($request);
        if(empty($data['resultData']['result'])){
            return $this->responseWithError(___('alert.Marksheet not found'), []);
        }

        $pdf = PDF::loadView('backend.report.marksheetPDF', compact('data'));

        $fileName = 'marksheet_' . date('d_m_Y') . '_' . @$data['student']->first_name . '_' . @$data['student']->last_name . '.pdf';

        // Save to storage/app/public/marksheets
        Storage::disk('public')->put('marksheets/' . $fileName, $pdf->output());

        // Get full URL
        $result['student_name'] = @$data['student']->full_name;
        $result['admission_no'] = @$data['student']->admission_no;
        $result['class_sec'] = @$data['class_sec'];
        $result['exam_type'] = ExamType::find($request->exam_type)->name;
        $result['result'] = @$data['resultData']['result'];
        $result['avg_marks'] = @round($data['resultData']['avg_marks'], 2) .'%';
        $result['gpa'] = @$data['resultData']['gpa'];
        $result['makesheet_download_url'] = asset('storage/marksheets/' . $fileName);
        return $this->responseWithSuccess(___('alert.success'), $result);
    }
    public function studentProgressCard(){

        if(!request(('student_id'))){
             return $this->responseWithError(___('alert.Student not found'), []);
        }

        $request = new Request([
            'student'   => request('student_id'),
            'class'     => request('class_id'),
            'section'   =>request('section_id'),
        ]);


        $data   = $this->progressCardrepo->search($request);
        $data['class_sec'] = Classes::find($request->class)->name.'-'.Section::find($request->section)->name;
        $data['student']      = $this->studentRepo->show(request(('student_id')));


        if(empty($data)){
            return $this->responseWithError(___('alert.Progress Card not found'), []);
        }

        $pdf = PDF::loadView('backend.report.progress-cardPDF', compact('data'));
        $fileName = 'progress_card_' . date('d_m_Y') . '_' . @$data['student']->first_name . '_' . @$data['student']->last_name . '.pdf';

        Storage::disk('public')->put('progress_card/' . $fileName, $pdf->output());

        $result['progress_card_download_url'] = asset('storage/progress_card/' . $fileName);
        $result['student_name'] = @$data['student']->full_name;
        $result['admission_no'] = @$data['student']->admission_no;
        $result['class_sec'] = @$data['class_sec'];
        return $this->responseWithSuccess(___('alert.success'), $result);
    }

    public function studentMeritList(){

        request()->merge(array_map(function ($value) {
        return $value === 'null' ? null : $value;
        }, request()->all()));

        if(!request(('exam_type_id'))){
             return $this->responseWithError(___('alert.Exam type Required'), []);
        }
        if(!request(('class_id'))){
             return $this->responseWithError(___('alert.Class Required'), []);
        }


        $request = new Request([
            'exam_type' => request('exam_type_id'),
            'class'     => request('class_id'),
            'section'   =>request('section_id'),
        ]);

        $data = MeritlistResource::collection($this->meritListRepo->search($request));
        return $this->responseWithSuccess(___('alert.success'),  $data);
    }


     public function attendanceReport(Request $request)
    {
        try {
            $request->merge(['view' => 1]);
            $results              = $this->attendanceRepo->searchReportPDF($request);
            $data['students']     = $results['students'];
            $data['days']         = $results['days'];
            $data['attendances']  = $results['attendances'];
            $data['request']      = $request;
            $data['class_name']      = Classes::find($request->classes_id)?->name;
            $data['section_name']      = Section::find($request->section_id) ? Section::find($request->section_id)->name : 'All';
            $pdf = PDF::loadView('backend.attendance.reportPDF', compact('data'));
            $fileName = 'attendance_report_' . date('d_m_Y') . '.pdf';
            Storage::disk('public')->put('attendance_report/' . $fileName, $pdf->output());
            $result['class'] = @$data['class_name'];
            $result['section'] = @$data['section_name'];
            $result['attendance_date'] = Carbon::parse($request->date)->format('l j F Y');
            $result['attendance_report_download_url'] = asset('storage/attendance_report/' . $fileName);
            return $this->responseWithSuccess(___('alert.success'), $result);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), []);
        }
    }
}
