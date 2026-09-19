<?php

namespace App\Http\Controllers\StudentInfo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Fees\FeesGroupRepository;
use Illuminate\Validation\ValidationException;
use App\Repositories\Fees\FeesMasterRepository;
use App\Repositories\Academic\ClassesRepository;
use App\Repositories\Academic\SectionRepository;
use App\Repositories\StudentInfo\OnlineAdmissionRepository;
use App\Repositories\StudentInfo\OnlineAdmissionSettingRepository;
use App\Http\Requests\StudentInfo\OnlineAdmission\OnlineAdmissionRequest;
use App\Http\Requests\StudentInfo\OnlineAdmission\OnlineAdmissionFeesAssignRequest;

class OnlineAdmissionSettingController extends Controller
{

    protected $setting_repo;
    protected $feesrepo;
    protected $classRepo;
    protected $sectionRepo;
    protected $feesGroup;

    public function __construct(OnlineAdmissionSettingRepository $setting_repo , ClassesRepository $classRepo,
                OnlineAdmissionRepository $feesrepo,
                FeesGroupRepository $feesGroup,
                SectionRepository $sectionRepo
    )
    {
        $this->setting_repo = $setting_repo;
        $this->classRepo = $classRepo;
        $this->feesrepo = $feesrepo;
        $this->feesGroup = $feesGroup;
        $this->sectionRepo = $sectionRepo;
    }

    public function index(){
        $data['title']    = ___('student_info.online_admission_setting');
        $data['fields']   = $this->setting_repo->getAllByType('online_admission');
        $data['title']    = ___('student_info.online_admission');
        $data['admission_payment_info'] = $this->setting_repo->getOneByFied('admission_payment_info');
        $data['admission_payment'] = $this->setting_repo->getOneByFied('admission_payment');
        return view('backend.student-info.online-admission.setting', compact('data'));
    }

    public function fees(){
        $data['title']    = ___('student_info.online_admission_setting');
        $data['classes']  = $this->classRepo->assignedAll();
        $data['fees_groups']  = $this->feesGroup->onlineAdmissionFeesMasters();
        $data['fees']   = $this->setting_repo->getAllFeesPaginate();
        $data['title']  = ___('student_info.online_admission');
        return view('backend.student-info.online-admission.fees', compact('data'));
    }

    public function feesStore(OnlineAdmissionFeesAssignRequest $request){

        $exist_check = $this->setting_repo->getAllFees()->where('session_id',$request->session_id)->where('class_id',$request->class)->where('section_id',$request->section)->where('fees_group_id',$request->fees_group)->first();
        if($exist_check){
            throw ValidationException::withMessages([
                'admission_fees_master' => ['These Admission Fees Master Already Assigned'],
            ]);
        }

        $result = $this->setting_repo->feesStore($request);
        if($result['status']){
            return redirect()->back()->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);

    }


    public function feesEdit($id){
        $data['title']    = ___('student_info.online_admission_setting');
        $data['classes']  = $this->classRepo->assignedAll();
        $data['sections']  = $this->sectionRepo->all();
        $data['fees_groups']  = $this->feesGroup->onlineAdmissionFeesMasters();
        $data['fees']   = $this->setting_repo->getAllFeesPaginate();
        $data['title']    = ___('student_info.online_admission');
        $assign_fees   = $this->setting_repo->onlineFeesAssignShow($id);
        return view('backend.student-info.online-admission.fees', compact('data','assign_fees'));
    }

    public function feesUpdate(OnlineAdmissionFeesAssignRequest $request){

        $exist_check = $this->setting_repo->getAllFees()->where('id', '!=', $request->id)->where('session_id',$request->session_id)->where('class_id',$request->class)->where('section_id',$request->section)->where('fees_group_id',$request->fees_group)->first();
        if($exist_check){
            throw ValidationException::withMessages([
                'admission_fees_master' => ['These Admission Fees Master Previously Assigned'],
            ]);
        }
        $result = $this->setting_repo->feesUpdate($request);
        if($result['status']){
            return redirect()->route('online-admissions.setting.fees')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function update(Request $request){

        $result = $this->setting_repo->update($request);
        if($result['status']){
            return redirect()->route('online-admissions.setting.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function delete($id)
    {
        $result = $this->setting_repo->destroy($id);
        if($result['status']):
            $success[0] = $result['message'];
            $success[1] = 'success';
            $success[2] = ___('alert.deleted');
            $success[3] = ___('alert.OK');
            return response()->json($success);
        else:
            $success[0] = $result['message'];
            $success[1] = 'error';
            $success[2] = ___('alert.oops');
            return response()->json($success);
        endif;
    }
}
