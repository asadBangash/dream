<?php

namespace App\Http\Controllers\WebsiteSetup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\WebsiteSetup\Gallery\GalleryStoreRequest;
use App\Http\Requests\WebsiteSetup\Gallery\GalleryUpdateRequest;
use App\Repositories\WebsiteSetup\GalleryCategoryRepository;
use App\Repositories\WebsiteSetup\GalleryRepository;
use Illuminate\Support\Facades\Schema;

class GalleryController extends Controller
{
    private $Repo, $categoryRepo;

    function __construct(GalleryRepository $Repo, GalleryCategoryRepository $categoryRepo)
    {
        if (!Schema::hasTable('settings') && !Schema::hasTable('users')  ) {
            abort(400);
        }
        $this->Repo  = $Repo;
        $this->categoryRepo  = $categoryRepo;
    }

    public function index()
    {
         $data['gallery'] = $this->Repo->getAll();
        $data['title'] = ___('settings.Images');
        return view('website-setup.gallery.index', compact('data'));
    }

    public function create()
    {
        $data['title']       = ___('website.Create Image');
        $data['categories']  = $this->categoryRepo->all();
        return view('website-setup.gallery.create', compact('data'));
    }

    public function store(GalleryStoreRequest $request)
    {
        $result = $this->Repo->store($request);
        if($result['status']){
            return redirect()->route('gallery.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }


    public function edit($id)
    {
        $data['title']       = ___('website.Edit Image');
        $data['gallery']     = $this->Repo->show($id);
        $data['categories']  = $this->categoryRepo->all();
        return view('website-setup.gallery.edit', compact('data'));
    }

    public function update(GalleryUpdateRequest $request, $id)
    {
        $result = $this->Repo->update($request, $id);
        if($result['status']){
            return redirect()->route('gallery.index')->with('success', $result['message']);
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
