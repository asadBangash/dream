<?php

namespace Modules\MainApp\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Modules\MainApp\Http\Requests\FAQ\StoreRequest;
use Modules\MainApp\Http\Requests\FAQ\UpdateRequest;
use Modules\MainApp\Http\Repositories\FAQRepository;

class FAQController extends Controller
{
    private $repo;

    function __construct(FAQRepository $repo)
    {

        if (!Schema::hasTable('settings') && !Schema::hasTable('users')  ) {
            abort(400);
        } 
        $this->repo       = $repo; 
    }

    public function index()
    {
        $data['faqs']  = $this->repo->getAll();
        $data['title'] = ___('settings.FAQ');
        return view('mainapp::faq.index', compact('data'));
    }

    public function create()
    {
        $data['title'] = ___('settings.Create faq');
        return view('mainapp::faq.create', compact('data'));
    }

    public function store(StoreRequest $request)
    {
        $result = $this->repo->store($request);
        if($result['status']){
            return redirect()->route('faq.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $data['faq']   = $this->repo->show($id);
        $data['title'] = ___('settings.Edit faq');
        return view('mainapp::faq.edit', compact('data'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $result = $this->repo->update($request, $id);
        if($result['status']){
            return redirect()->route('faq.index')->with('success', $result['message']);
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
