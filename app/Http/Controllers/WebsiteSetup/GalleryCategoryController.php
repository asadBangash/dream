<?php

namespace App\Http\Controllers\WebsiteSetup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\WebsiteSetup\GalleryCategory\GalleryCategoryStoreRequest;
use App\Http\Requests\WebsiteSetup\GalleryCategory\GalleryCategoryUpdateRequest;
use App\Repositories\LanguageRepository;
use App\Repositories\WebsiteSetup\GalleryCategoryRepository;
use Illuminate\Support\Facades\Schema;

class GalleryCategoryController extends Controller
{
    private $Repo;
    private $lang_repo;



    function __construct(GalleryCategoryRepository $Repo , LanguageRepository $lang_repo)
    {
        if (!Schema::hasTable('settings') && !Schema::hasTable('users')  ) {
            abort(400);
        }
        $this->Repo                  = $Repo;
        $this->lang_repo                  = $lang_repo;
    }

    public function index()
    {
        $data['gallery_category'] = $this->Repo->getAll();
        $data['title'] = ___('settings.Gallery_category');
        return view('website-setup.gallery-category.index', compact('data'));
    }

    public function create()
    {
        $data['title']       = ___('website.create_gallery_category');
        return view('website-setup.gallery-category.create', compact('data'));
    }

    public function store(GalleryCategoryStoreRequest $request)
    {
        $result = $this->Repo->store($request);
        if($result['status']){
            return redirect()->route('gallery-category.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $data['gallery_category']      = $this->Repo->show($id);
        $data['title']       = ___('website.edit_gallery_category');
        return view('website-setup.gallery-category.edit', compact('data'));
    }

    public function translate($id)
    {
        $data['gallery_category']      = $this->Repo->show($id);
        $data['title']       = ___('website.translate_gallery_category');
        $data['languages']      = $this->lang_repo->all();
        $data['translates']      = $this->Repo->translates($id);
        return view('website-setup.gallery-category.translate', compact('data'));
    }

    public function translateUpdate(Request $request , $id)
    {
        $result = $this->Repo->translateUpdate($request, $id);
        if($result['status']){
            return redirect()->route('gallery-category.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function update(GalleryCategoryUpdateRequest $request, $id)
    {
        $result = $this->Repo->update($request, $id);
        if($result['status']){
           return redirect()->route('gallery-category.index')->with('success', $result['message']);
        }
        
        return back()->with('danger', $result['message']);
    }

    public function delete($id)
    {
        $result = $this->Repo->destroy($id);
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
