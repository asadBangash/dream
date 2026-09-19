<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SmsMailTemplate\SmsMailTemplateRepository;
use App\Http\Requests\SmsMailTemplate\SmsMailTemplateStoreRequest;

class SmsMailTemplateController extends Controller
{
    private $repo;

    function __construct(SmsMailTemplateRepository $repo)
    {
        $this->repo               = $repo;
    }

    public function index()
    {
        $data['title']              = ___('common.SMS/Mail_template');
        $data['templates']      = $this->repo->getPaginateAll();
        
        return view('backend.communication.template.index', compact('data'));
    }

    public function create()
    {
        $data['title']                  = ___('common.SMS/Mail_template_create');
        return view('backend.communication.template.create', compact('data'));
    }

    public function store(SmsMailTemplateStoreRequest $request)
    {
        $result = $this->repo->store($request);
        if($result['status']){
            return redirect()->route('template.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
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
}
