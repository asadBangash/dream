<?php

namespace App\Http\Controllers\WebsiteSetup;

use App\Http\Controllers\Controller;
use App\Http\Requests\WebsiteSetup\Slider\SliderStoreRequest;
use App\Http\Requests\WebsiteSetup\Slider\SliderUpdateRequest;
use App\Repositories\LanguageRepository;
use App\Repositories\WebsiteSetup\SliderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SliderController extends Controller
{
    private $sliderRepo;
    private $lang_repo;

    public function __construct(SliderRepository $sliderRepo, LanguageRepository $lang_repo)
    {
        if (!Schema::hasTable('settings') && !Schema::hasTable('users')) {
            abort(400);
        }
        $this->sliderRepo = $sliderRepo;
        $this->lang_repo  = $lang_repo;
    }

    public function index()
    {
        $data['slider'] = $this->sliderRepo->getAll();
        $data['title']  = ___('settings.Slider');
        return view('website-setup.slider.index', compact('data'));
    }

    public function create()
    {
        $data['title'] = ___('website.create_slider');
        return view('website-setup.slider.create', compact('data'));
    }

    public function store(SliderStoreRequest $request)
    {
        $result = $this->sliderRepo->store($request);
        if ($result['status']) {
            return redirect()->route('slider.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        try {
            $data['slider'] = $this->sliderRepo->show($id);
            $data['title']  = ___('website.edit_slider');
            return view('website-setup.slider.edit', compact('data'));
        } catch (\Exception $e) {
            return back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function update(SliderUpdateRequest $request, $id)
    {

        // dd($request->all());
        $result = $this->sliderRepo->update($request, $id);
        // dd($result);
        if ($result['status']) {
            return redirect()->route('slider.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function translate($id)
    {
        $data['slider']     = $this->sliderRepo->show($id);
        $data['translates'] = $this->sliderRepo->translates($id);
        $data['languages']  = $this->lang_repo->all();
        $data['title']      = ___('website.edit_slider');
        return view('website-setup.slider.translate', compact('data'));
    }

    public function translateUpdate(Request $request, $id)
    {
        $result = $this->sliderRepo->translateUpdate($request, $id);
        if ($result['status']) {
            return redirect()->route('slider.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function delete($id)
    {
        $result = $this->sliderRepo->destroy($id);
        if ($result['status']):
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