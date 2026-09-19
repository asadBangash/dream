<?php

namespace App\Http\Controllers\WebsiteSetup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\WebsiteSetup\NewsRepository;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\WebsiteSetup\News\NewsStoreRequest;
use App\Http\Requests\WebsiteSetup\News\NewsUpdateRequest;
use App\Repositories\LanguageRepository;

class NewsController extends Controller
{
    private $newsRepo;
    private $lang_repo;

    function __construct(NewsRepository $newsRepo, LanguageRepository $lang_repo)
    {
        if (!Schema::hasTable('settings') && !Schema::hasTable('users')  ) {
            abort(400);
        }
        $this->newsRepo                  = $newsRepo;
        $this->lang_repo                  = $lang_repo;
    }

    public function index()
    {
        $data['news'] = $this->newsRepo->getAll();
        $data['title'] = ___('settings.News');
        return view('website-setup.news.index', compact('data'));
    }

    public function create()
    {
        $data['title']       = ___('website.create_news');
        return view('website-setup.news.create', compact('data'));
    }

    public function store(NewsStoreRequest $request)
    {
        $result = $this->newsRepo->store($request);
        if($result['status']){
            return redirect()->route('news.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $data['news']      = $this->newsRepo->show($id);
        $data['title']       = ___('website.Edit news');
        return view('website-setup.news.edit', compact('data'));
    }

    public function update(NewsUpdateRequest $request, $id)
    {
        $result = $this->newsRepo->update($request, $id);
        if($result['status']){
            return redirect()->route('news.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function translate($id)
    {
        $data['news']      = $this->newsRepo->show($id);
        $data['translates']      = $this->newsRepo->translates($id);
        $data['languages']      = $this->lang_repo->all();
        $data['title']       = ___('website.Edit News');
        return view('website-setup.news.translate', compact('data'));
    }

    public function translateUpdate(Request $request, $id)
    {
        $result = $this->newsRepo->translateUpdate($request, $id);
        if($result['status']){
            return redirect()->route('news.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function delete($id)
    {
        $result = $this->newsRepo->destroy($id);
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
