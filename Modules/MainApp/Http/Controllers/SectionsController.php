<?php

namespace Modules\MainApp\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Modules\MainApp\Http\Repositories\SectionsRepository;

class SectionsController extends Controller
{
    private $repo;

    function __construct(SectionsRepository $repo)
    {
        if (!Schema::hasTable('settings') && !Schema::hasTable('users')  ) {
            abort(400);
        }
        $this->repo                  = $repo;
    }

    public function index()
    {
        $data['sections'] = $this->repo->getAll();
        $data['title']    = ___('settings.sections');
        return view('mainapp::sections.index', compact('data'));
    }

    public function edit($id)
    {
        $data['sections'] = $this->repo->show($id);
        $data['title']    = ___('website.edit_sections');
        return view('mainapp::sections.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $result = $this->repo->update($request, $id);
        if($result['status']){
            return redirect()->route('sections.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function addSocialLink(Request $request)
    {
        return view('mainapp::sections.add_social_link')->render();
    }
}
