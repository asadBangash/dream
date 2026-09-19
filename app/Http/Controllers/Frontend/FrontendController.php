<?php

namespace App\Http\Controllers\Frontend;

use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\GenderRepository;
use Illuminate\Support\Facades\Schema;
use App\Repositories\ReligionRepository;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Report\MarksheetRepository;
use App\Repositories\Frontend\FrontendRepository;
use App\Repositories\WebsiteSetup\PageRepository;
use App\Http\Requests\Frontend\SearchResultRequest;
use App\Repositories\Academic\ShiftRepository;
use App\Repositories\StudentInfo\StudentRepository;
use App\Repositories\StudentInfo\OnlineAdmissionSettingRepository;

class FrontendController extends Controller
{
    private $repo;
    private $religionRepo;
    private $genderRepo;
    private $marksheetRepo;
    private $studentRepo;
    private $pageRepo;
    private $admission_setting_repo;
    private $shift_repo;

    function __construct(
        FrontendRepository $repo,
        ReligionRepository $religionRepo,
        GenderRepository   $genderRepo,
        MarksheetRepository    $marksheetRepo,
        StudentRepository      $studentRepo,
        PageRepository      $pageRepo,
        OnlineAdmissionSettingRepository      $admission_setting_repo,
        ShiftRepository      $shift_repo,
    )
    {
        if (!Schema::hasTable('settings') && !Schema::hasTable('users'))
            abort(400);
        $this->repo         = $repo;
        $this->religionRepo = $religionRepo;
        $this->genderRepo   = $genderRepo;
        $this->marksheetRepo      = $marksheetRepo;
        $this->studentRepo        = $studentRepo;
        $this->pageRepo        = $pageRepo;
        $this->admission_setting_repo        = $admission_setting_repo;
        $this->shift_repo        = $shift_repo;
    }

    public function index()
    {
        $data['sliders']          = $this->repo->sliders();
        
        $data['counters']         = $this->repo->counters();
        $data['galleryCategory']  = $this->repo->galleryCategory();
        $data['gallery']          = $this->repo->gallery();
        $data['latestNews']       = $this->repo->latestNews();
        $data['comingEvents']     = $this->repo->comingEvents();

        return view('frontend.home', compact('data'));
    }

    // Result
    public function getClasses(Request $request){
        $data = $this->repo->getClasses($request); // session id
        return response()->json($data);
    }
    public function getSections(Request $request){
        $data = $this->repo->getSections($request); // class id
        return response()->json($data);
    }
    public function getExamType(Request $request)
    {
        $result = $this->repo->getExamType($request);
        return response()->json($result, 200);
    }
    public function result()
    {
        $data = $this->repo->result();
        $data['result'] = null;
        return view('frontend.result', compact('data'));
    }

    public function searchResult(SearchResultRequest $request){
        $data = $this->repo->searchResult($request);
        if(!$data)
        {
            $data = $this->repo->result();
            $data['result'] = "Result not found!";
            return view('frontend.result', compact('data'));
        }
        $data['request'] = $request;
        return view('frontend.search_result', compact('data'));
    }

    public function downloadPDF($id, $type, $class, $section)
    {
        $request = new Request([
            'student'   => $id,
            'exam_type' => $type,
            'class'     => $class,
            'section'   => $section,
        ]);

        $data['student']      = $this->studentRepo->show($request->student);
        $data['resultData']   = $this->marksheetRepo->search($request);

        $pdf = PDF::loadView('backend.report.marksheetPDF', compact('data'));
        return $pdf->download('marksheet'.'_'.date('d_m_Y').'_'.@$data['student']->first_name .'_'. @$data['student']->last_name .'.pdf');
    }

    public function about()
    {
        $data = $this->repo->abouts();

        return view('frontend.about', compact('data'));
    }

    // Blog
    public function news()
    {
        $data['news'] = $this->repo->news();
        return view('frontend.news', compact('data'));
    }
    public function newsDetail($id)
    {
        $data['allNews'] = $this->repo->news();
        $data['news']    = $this->repo->newsDetail($id);
        return view('frontend.news-detail', compact('data'));
    }

    // Event
    public function events()
    {
        $events = $this->repo->events();
        return view('frontend.events', compact('events'));
    }
    public function eventDetail($id)
    {
        $data['allEvent'] = $this->repo->events();
        $data['event']    = $this->repo->eventDetail($id);
        return view('frontend.event-detail', compact('data'));
    }


    public function page($slug)
    {
        $data['page']    = $this->pageRepo->findBySlug($slug);
        return view('frontend.page-detail', compact('data'));
    }


    // Event
    public function notices()
    {
        $data['notices'] = $this->repo->notices();
        return view('frontend.notices', compact('data'));
    }
    public function noticeDetail($id)
    {
        $data['allNotice'] = $this->repo->notices();
        $data['notice-board']    = $this->repo->noticeDetail($id);
        return view('frontend.notice-detail', compact('data'));
    }

    // Contact
    public function contact()
    {
        $data['contactInfo']    = $this->repo->contactInfo();
        $data['depContact']     = $this->repo->depContact();
        return view('frontend.contact', compact('data'));
    }

    // onlineAdmission
    public function onlineAdmission()
    {
        $data = $this->repo->result();
        $data['religions']= $this->religionRepo->all();
        $data['genders']  = $this->genderRepo->all();
        $data['shifts']  = $this->shift_repo->all();
        $data['setting']  = $this->admission_setting_repo->getIsShowByType('online_admission');
        return view('frontend.online-admission', compact('data'));
    }


        // onlineAdmission
        public function onlineAdmissionFees($student_phone, $admission_id)
        {
            $data['admission'] = $this->repo->onlineAdmissionDetail($admission_id);
            $data['setting']  = $this->admission_setting_repo->getIsShowByType('online_admission');
            $data['fees'] = $this->repo->onlineAdmissionFees($data['admission']->session_id, $data['admission']->classes_id , $data['admission']->section_id);
            $data['payment_instruction'] = $this->admission_setting_repo->getOneByFied('admission_payment_info');
            if($data['admission']->payment_status == 2 && $data['fees']){
                return view('frontend.online-admission-fees', compact('data'));
            }

            return view('frontend.online-admission-fees', compact('data'));
        }

    public function storeOnlineAdmission(Request $request) {

        $admission = $this->repo->onlineAdmission($request);
        $fees = $this->repo->onlineAdmissionFees($admission->session_id, $admission->classes_id , $admission->section_id);
        $payment_setting = $this->admission_setting_repo->getOneByFied('admission_payment');

        if($admission && $fees && $payment_setting->is_show == 1){
            return redirect()->route('frontend.online-admission-fees',[$admission->reference_no , $admission->id])->with('message' , 'Admission Inform submitted successfully , Please wait for school approval');
        }
        return redirect()->back()->with('message' , 'Admission Inform submitted successfully, Please wait for school approval');

    }


    public function storeOnlineAdmissionFees(Request $request) {
        $validator = Validator::make($request->all(), [
            'payment_image' => 'required|mimes:jpeg,png,jpg,gif'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $admission = $this->repo->storeOnlineAdmissionFees($request);

        if($admission){
            return redirect()->route('frontend.online-admission')->with('message' , 'Admission Inform submitted successfully , Please complete payment for successfully admission');
        }
    }

    public function storeContact(Request $request)
    {
        return $this->repo->contact($request);
    }

    public function storeSubscribe(Request $request)
    {
        return $this->repo->subscribe($request);
    }
}