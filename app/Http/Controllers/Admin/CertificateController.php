<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Academic\ClassSetupRepository;
use App\Repositories\Certificate\CertificateRepository;
use App\Http\Requests\Certificate\CertificateStoreRequest;
use App\Http\Requests\Certificate\CertificateSearchRequest;
use App\Http\Requests\Certificate\CertificateUpdateRequest;

class CertificateController extends Controller
{
    private $repo;
    private $classSetupRepo;

    function __construct(CertificateRepository $repo, ClassSetupRepository $classSetupRepo)
    {
        $this->repo               = $repo;
        $this->classSetupRepo     = $classSetupRepo;
    }

    public function index()
    {
        $data['title']              = ___('common.certificate list');
        $data['certificates']           = $this->repo->getPaginateAll();
        return view('backend.certificate.index', compact('data'));
    }

    public function create()
    {
        $data['title']                  = ___('common.certificate create');
        return view('backend.certificate.create', compact('data'));
    }

    public function store(CertificateStoreRequest $request)
    {
        $result = $this->repo->store($request);
        if($result['status']){
            return redirect()->route('certificate.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id, Request $request)
    {
        $data['certificate']              = $this->repo->show($id);

        
        $data['title']                 = ___('common.certificate edit');
        return view('backend.certificate.edit', compact('data'));
    }

    public function update(CertificateUpdateRequest $request, $id)
    {
        $result = $this->repo->update($request, $id);
        if($result['status']){
            return redirect()->route('certificate.index')->with('success', $result['message']);
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

    public function preview(Request $request)
    {
        $data['certificate'] = $this->repo->show($request->certificate_id);
        
        $data['view'] = view('backend.certificate.preview', compact('data'))->render();

        return response()->json($data);

    }

    public function generate()
    {
        $data['title']              = ___('common.Generate certificate');
        $data['certificates']       = $this->repo->all();
        $data['classes']            = $this->classSetupRepo->all();
        return view('backend.certificate.generate', compact('data'));
    }

    public function generateSearch(CertificateSearchRequest $request)
    {
        $result = $this->repo->generateSearch($request);
        if ($result['status']) {

            $data['certificate']        = $result['data']['certificate'];
            $data['students']           = $result['data']['students'];
            $data['session']            = $result['data']['session'];
            $data['title']              = ___('common.Generate certificate');

            $data['certificates']       = $this->repo->all();
            $data['classes']            = $this->classSetupRepo->all();

            return view('backend.certificate.generate', compact('data'));
        }
        return back()->with('danger', $result['message']);

    }


}
