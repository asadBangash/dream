<?php

namespace Modules\MainApp\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Modules\MainApp\Http\Repositories\PackageRepository;
use Modules\MainApp\Http\Requests\School\StoreRequest;
use Modules\MainApp\Http\Requests\School\UpdateRequest;
use Modules\MainApp\Http\Repositories\SchoolRepository;

class SchoolController extends Controller
{
    private $repo;
    private $packageRepo;

    function __construct(
        SchoolRepository $repo,
        PackageRepository $packageRepo,
    )
    {

        if (!Schema::hasTable('settings') && !Schema::hasTable('users')  ) {
            abort(400);
        }
        $this->repo        = $repo;
        $this->packageRepo = $packageRepo;
    }

    public function index()
    {
        $data['schools'] = $this->repo->getAll();
        $data['title']   = ___('settings.Schools');
        return view('mainapp::school.index', compact('data'));
    }

    public function create()
    {
        $data['title']    = ___('settings.Create school');
        $data['packages'] = $this->packageRepo->all();
        return view('mainapp::school.create', compact('data'));
    }

    public function store(StoreRequest $request)
    {
        ini_set('max_execution_time', 300);
        $result = $this->repo->store($request);

        if($result['status']){
            return redirect()->route('school.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $data['school']   = $this->repo->show($id);
        $data['title']    = ___('settings.Edit school');
        $data['packages'] = $this->packageRepo->all();
        return view('mainapp::school.edit', compact('data'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $result = $this->repo->update($request, $id);
        if($result['status']){
            return redirect()->route('school.index')->with('success', $result['message']);
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
