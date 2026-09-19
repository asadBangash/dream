<?php

namespace Modules\MainApp\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Modules\MainApp\Http\Repositories\FeatureRepository;
use Modules\MainApp\Http\Requests\Package\StoreRequest;
use Modules\MainApp\Http\Requests\Package\UpdateRequest;
use Modules\MainApp\Http\Repositories\PackageRepository;

class PackageController extends Controller
{
    private $repo;
    private $featureRepo;

    function __construct(
        PackageRepository $repo,
        FeatureRepository $featureRepo,
    )
    {

        if (!Schema::hasTable('settings') && !Schema::hasTable('users')  ) {
            abort(400);
        }
        $this->repo       = $repo;
        $this->featureRepo= $featureRepo;
    }

    public function index()
    {
        $data['packages'] = $this->repo->getAll();
        $data['title']    = ___('settings.Packages');
        return view('mainapp::package.index', compact('data'));
    }

    public function create()
    {
        $data['features'] = $this->featureRepo->all();
        $data['title']    = ___('settings.Create package');
        return view('mainapp::package.create', compact('data'));
    }

    public function store(StoreRequest $request)
    {
        $result = $this->repo->store($request);
        if($result['status']){
            return redirect()->route('package.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $data['features']    = $this->featureRepo->all();
        $data['package']     = $this->repo->show($id);
        $data['title']       = ___('settings.Edit package');
        return view('mainapp::package.edit', compact('data'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $result = $this->repo->update($request, $id);
        if($result['status']){
            return redirect()->route('package.index')->with('success', $result['message']);
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
