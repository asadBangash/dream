<?php

namespace Modules\MainApp\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Modules\MainApp\Http\Requests\Feature\StoreRequest;
use Modules\MainApp\Http\Requests\Feature\UpdateRequest;
use Modules\MainApp\Http\Repositories\FeatureRepository;

class FeatureController extends Controller
{
    private $repo;

    function __construct(FeatureRepository $repo)
    {

        if (!Schema::hasTable('settings') && !Schema::hasTable('users')  ) {
            abort(400);
        } 
        $this->repo = $repo; 
    }

    public function index()
    {
        $data['features'] = $this->repo->getAll();
        $data['title']    = ___('settings.Features');
        return view('mainapp::feature.index', compact('data'));
    }

    public function create()
    {
        $data['title'] = ___('settings.Create feature');
        return view('mainapp::feature.create', compact('data'));
    }

    public function store(StoreRequest $request)
    {
        $result = $this->repo->store($request);
        if($result['status']){
            return redirect()->route('feature.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $data['feature']  = $this->repo->show($id);
        $data['title']    = ___('settings.Edit feature');
        return view('mainapp::feature.edit', compact('data'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $result = $this->repo->update($request, $id);
        if($result['status']){
            return redirect()->route('feature.index')->with('success', $result['message']);
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
