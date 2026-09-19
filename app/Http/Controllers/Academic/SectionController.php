<?php

namespace App\Http\Controllers\Academic;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Academic\Section\SectionStoreRequest;
use App\Http\Requests\Academic\Section\SectionUpdateRequest;
use App\Interfaces\Academic\SectionInterface;
use App\Repositories\LanguageRepository;
use Illuminate\Support\Facades\Schema;

class SectionController extends Controller
{
    private $section;
    private $lang_repo;

    function __construct(SectionInterface $section , LanguageRepository $lang_repo)
    {

        if (!Schema::hasTable('settings') && !Schema::hasTable('users')  ) {
            abort(400);
        }
        $this->section       = $section;
        $this->lang_repo       = $lang_repo;
    }

    public function index()
    {
        $data['section'] = $this->section->getAll();
        $data['title'] = ___('academic.section');
        return view('backend.academic.section.index', compact('data'));
    }

    public function create()
    {
        $data['title']       = ___('academic.create_section');
        return view('backend.academic.section.create', compact('data'));
    }

    public function store(SectionStoreRequest $request)
    {
        $result = $this->section->store($request);
        if($result['status']){
            return redirect()->route('section.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $data['section']        = $this->section->show($id);
        $data['title']       = ___('academic.edit_section');
        return view('backend.academic.section.edit', compact('data'));
    }

    public function update(SectionUpdateRequest $request, $id)
    {
        $result = $this->section->update($request, $id);
        if($result['status']){
            return redirect()->route('section.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function delete($id)
    {
        $result = $this->section->destroy($id);
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


    public function translate($id)
    {
        $data['section']        = $this->section->show($id);
        $data['translates']      = $this->section->translates($id);
        $data['languages']      = $this->lang_repo->all();
        $data['title']       = ___('academic.edit_section');
        return view('backend.academic.section.translate', compact('data'));
    }

    public function translateUpdate(Request $request, $id){

        $result = $this->section->translateUpdate($request, $id);
        if($result['status']){
            return redirect()->route('section.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }
}
