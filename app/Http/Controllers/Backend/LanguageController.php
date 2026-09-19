<?php

namespace App\Http\Controllers\Backend;

use App;
use Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Interfaces\FlagIconInterface;
use App\Interfaces\LanguageInterface;
use Session;
use Illuminate\Support\Facades\Schema;
use App\Interfaces\PermissionInterface;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Language\LanguageStoreRequest;
use App\Http\Requests\Language\LanguageUpdateRequest;

class LanguageController extends Controller
{
    private $language;
    private $permission;
    private $flagIcon;

    function __construct(LanguageInterface $languageInterface, PermissionInterface $permissionInterface, FlagIconInterface $flagIconInterface)
    {

        if (!Schema::hasTable('settings') && !Schema::hasTable('users')  ) {
            abort(400);
        }
        $this->language   = $languageInterface;
        $this->permission = $permissionInterface;
        $this->flagIcon   = $flagIconInterface;
    }

    public function index()
    {
        $data['languages']  = $this->language->getAll();
        $data['title']      = ___('common.languages');
        return view('backend.languages.index',compact('data'));
    }

    public function create()
    {
        $data['title']       = ___('common.create_language');
        $data['permissions'] = $this->permission->all();
        $data['flagIcons']   = $this->flagIcon->getAll();
        return view('backend.languages.create', compact('data'));
    }

    public function store(LanguageStoreRequest $request)
    {
        $result = $this->language->store($request);
        if ($result) {
            return redirect()->route('languages.index')->with('success', ___('alert.language_created_successfully'));
        }
        return redirect()->route('languages.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
    }

    public function edit($id)
    {
        $data['language']    = $this->language->show($id);
        $data['title']       = ___('common.languages');
        $data['permissions'] = $this->permission->all();
        $data['flagIcons']   = $this->flagIcon->getAll();
        return view('backend.languages.edit',compact('data'));
    }

    public function update(LanguageUpdateRequest $request,$id)
    {
        $result = $this->language->update($request,$id);
        if($result){
            return redirect()->route('languages.index')->with('success', ___('alert.language_updated_successfully'));
        }
        return redirect()->route('languages.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
    }

    public function delete($id)
    {
        if ($this->language->destroy($id)):
            $success[0] = ___('alert.deleted_successfully');
            $success[1] = "success";
            $success[2] = ___('alert.deleted');
            $success[3] = ___('alert.OK');
        else:
            $success[0] = ___('alert.something_went_wrong_please_try_again');
            $success[1] = 'error';
            $success[2] = ___('alert.oops');
        endif;
        return response()->json($success);

    }

    public function terms($id)
    {
        $data = $this->language->terms($id);

        return view('backend.languages.terms',compact('data'));
    }

    public function termsUpdate(Request $request, $code)
    {
        try {
            $this->language->termsUpdate($request, $code);

            return redirect()->back()->with('success', ___('alert.language_terms_updated_successfully'));
        } catch (\Throwable $th) {
            info($th->getMessage());
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function changeModule(Request $request)
    {
        $path           = base_path('lang/' . $request->code);
        $jsonString     = file_get_contents(base_path("lang/$request->code/$request->module.json"));
        $data['terms']  = json_decode($jsonString, true);

        return view('backend.languages.ajax_terms', compact('data'))->render();
    }


    public function changeLanguage(Request $request)
    {
        $path = base_path('lang/' . $request->code);
        if(is_dir($path)){
            Session::put('locale', $request->code);
            return 1;
        }
        return 0;

    }

}
