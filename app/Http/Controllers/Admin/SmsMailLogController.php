<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\SmsMailTemplate;
use App\Http\Controllers\Controller;
use App\Repositories\RoleRepository;
use App\Repositories\Academic\ClassSetupRepository;
use App\Repositories\SmsMailLog\SmsMailLogRepository;
use App\Http\Requests\SmsMailLog\SmsMailLogStoreRequest;
use App\Repositories\SmsMailTemplate\SmsMailTemplateRepository;

class SmsMailLogController extends Controller
{
    private $templateRepo;
    private $repo;
    private $classSetupRepo;

    function __construct(
        SmsMailLogRepository $repo, 
        SmsMailTemplateRepository $templateRepo, 
        RoleRepository $roleRepo,
        ClassSetupRepository $classSetupRepo, 
        )
    {
        $this->templateRepo               = $templateRepo;
        $this->repo                       = $repo;
        $this->roleRepo                   = $roleRepo;
        $this->classSetupRepo             = $classSetupRepo;
    }

    public function index()
    {
        $data['title']        = ___('common.Sms/Mail');
        $data['smsmail']      = $this->repo->getPaginateAll();
        
        
        return view('backend.communication.smsmail.index', compact('data'));
    }

    public function create()
    {
        $data['title']                  = ___('common.SMS/Mail_template_create');
        $data['templates']              = $this->templateRepo->all();
        $data['roles']                  = $this->roleRepo->all();
        $data['classes']                = $this->classSetupRepo->all();

        return view('backend.communication.smsmail.create', compact('data'));
    }

    public function store(SmsMailLogStoreRequest $request)
    {
        $result = $this->repo->store($request);

        return response()->json($result);

    }

    public function edit($id, Request $request)
    {
        $data['template']              = $this->repo->show($id);
        $data['title']                 = ___('common.SMS/Mail_template_edit');
        return view('backend.communication.template.edit', compact('data'));
    }

    public function update(SmsMailTemplateStoreRequest $request, $id)
    {
        $result = $this->repo->update($request, $id);
        if($result['status']){
            return redirect()->route('template.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function delete($id)
    {

        $result = $this->repo->destroy($id);
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


    public function users(Request $request)
    {

        $users = User::where('role_id', $request->role_id)->get();
        
        return response()->json($users);

    }


    public function template(Request $request)
    {

        $template = SmsMailTemplate::with('attachmentFile')->find($request->template_id);
        
        return response()->json($template);

    }
}
