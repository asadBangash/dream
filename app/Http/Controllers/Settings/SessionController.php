<?php

namespace App\Http\Controllers\Settings;

use App\Models\Session;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\SessionInterface;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\Session\SessionStoreRequest;
use App\Http\Requests\Session\SessionUpdateRequest;
use App\Repositories\LanguageRepository;

class SessionController extends Controller
{
    private $session;
    private $lang_repo;

    function __construct(SessionInterface $session , LanguageRepository $lang_repo)
    {

        if (!Schema::hasTable('settings') && !Schema::hasTable('users')  ) {
            abort(400);
        }
        $this->session       = $session;
        $this->lang_repo       = $lang_repo;
    }

    public function index()
    {
        $data['sessions'] = $this->session->getAll();
        $data['title'] = ___('settings.sessions');
        return view('backend.session.index', compact('data'));
    }

    public function create()
    {
        $data['title']       = ___('settings.create_session');
        return view('backend.session.create', compact('data'));
    }

    public function store(SessionStoreRequest $request)
    {
        $result = $this->session->store($request);
        if($result['status']){
            return redirect()->route('sessions.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $data['session']        = $this->session->show($id);
        $data['title']       = ___('settings.edit_session');
        return view('backend.session.edit', compact('data'));
    }

    public function update(SessionUpdateRequest $request, $id)
    {
        $result = $this->session->update($request, $id);
        if($result['status']){
            return redirect()->route('sessions.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function delete($id)
    {
        $result = $this->session->destroy($id);
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

    public function changeSession(Request $request)
    {
        $setting = Setting::where('name', 'session')->update(
            ['value' => $request->id]
        );
        if($setting){
            return 1;
        }
        return 0;

    }

    public function translate($id)
    {
        $data['session']        = $this->session->show($id);
        $data['translates']      = $this->session->translates($id);
        $data['languages']      = $this->lang_repo->all();
        $data['title']       = ___('academic.edit_section');
        return view('backend.session.translate', compact('data'));
    }

    public function translateUpdate(Request $request, $id){
        $result = $this->session->translateUpdate($request, $id);
        if($result['status']){
            return redirect()->route('sessions.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }
}
