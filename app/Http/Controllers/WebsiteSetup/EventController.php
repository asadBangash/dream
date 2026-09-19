<?php

namespace App\Http\Controllers\WebsiteSetup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\WebsiteSetup\EventRepository;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\WebsiteSetup\Event\EventStoreRequest;
use App\Http\Requests\WebsiteSetup\Event\EventUpdateRequest;
use App\Repositories\LanguageRepository;

class EventController extends Controller
{
    private $eventRepo;
    private $lang_repo;

    function __construct(EventRepository $eventRepo, LanguageRepository $lang_repo)
    {
        if (!Schema::hasTable('settings') && !Schema::hasTable('users')  ) {
            abort(400);
        }
        $this->eventRepo                  = $eventRepo;
        $this->lang_repo                  = $lang_repo;
    }

    public function index()
    {
        $data['event'] = $this->eventRepo->getAll();
        $data['title'] = ___('settings.event');
        return view('website-setup.event.index', compact('data'));
    }

    public function create()
    {
        $data['title']       = ___('website.create_event');
        return view('website-setup.event.create', compact('data'));
    }

    public function store(EventStoreRequest $request)
    {
        $result = $this->eventRepo->store($request);
        if($result['status']){
            return redirect()->route('event.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $data['event']      = $this->eventRepo->show($id);
        $data['title']       = ___('website.edit_event');
        return view('website-setup.event.edit', compact('data'));
    }

    public function update(EventUpdateRequest $request, $id)
    {
        $result = $this->eventRepo->update($request, $id);
        if($result['status']){
            return redirect()->route('event.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function translate($id)
    {
        $data['event']      = $this->eventRepo->show($id);
        $data['translates']      = $this->eventRepo->translates($id);
        $data['languages']      = $this->lang_repo->all();
        $data['title']       = ___('website.edit_news');
        return view('website-setup.event.translate', compact('data'));
    }

    public function translateUpdate(Request $request, $id)
    {
        $result = $this->eventRepo->translateUpdate($request, $id);
        if($result['status']){
            return redirect()->route('news.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function delete($id)
    {
        $result = $this->eventRepo->destroy($id);
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
