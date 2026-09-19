<?php

namespace App\Http\Controllers\WebsiteSetup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use App\Repositories\WebsiteSetup\PageRepository;
use App\Http\Requests\WebsiteSetup\Page\PageRequest;
use App\Repositories\LanguageRepository;

class PagesController extends Controller
{
    private $page_repo;
    private $lang_repo;

    function __construct(PageRepository $page_repo, LanguageRepository $lang_repo)
    {
        if (!Schema::hasTable('settings') && !Schema::hasTable('users')  ) {
            abort(400);
        }
        $this->page_repo                  = $page_repo;
        $this->lang_repo                  = $lang_repo;

    }

    public function index()
    {
        $data['pages'] = $this->page_repo->getAll();
        $data['title'] = ___('common.page');
        return view('website-setup.page.index', compact('data'));
    }

    public function create()
    {
        $data['title']       = ___('website.create_page');
        return view('website-setup.page.create', compact('data'));
    }

    public function store(PageRequest $request)
    {
        $result = $this->page_repo->store($request);
        if($result['status']){
            return redirect()->route('page.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        try {
            $data['page'] = $this->page_repo->show($id);
            $data['title'] = ___('website.edit_page');
            return view('website-setup.page.edit', compact('data'));
        } catch (\Exception $e) {
            return back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function update(PageRequest $request, $id)
    {

        $result = $this->page_repo->update($request, $id);
        if($result['status']){
            return redirect()->route('page.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function translate($id)
    {
        $data['page']      = $this->page_repo->show($id);
        $data['translates']      = $this->page_repo->translates($id);
        $data['languages']      = $this->lang_repo->all();
        $data['title']       = ___('website.edit_page');
        return view('website-setup.page.translate', compact('data'));
    }


    public function translateUpdate(Request $request, $id)
    {
        $result = $this->page_repo->translateUpdate($request, $id);
        if($result['status']){
            return redirect()->route('page.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function delete($id)
    {
        $result = $this->page_repo->destroy($id);
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