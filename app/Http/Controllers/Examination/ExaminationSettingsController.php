<?php

namespace App\Http\Controllers\Examination;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Examination\ExaminationSettingsRepository;

class ExaminationSettingsController extends Controller
{
    private $repo;

    function __construct( ExaminationSettingsRepository $repo )
    {
        $this->repo               = $repo;
    }

    public function index()
    {
        $data['title']      = ___('settings.examination_settings');
        return view('backend.examination.settings.index', compact('data'));
    }

    public function update(Request $request)
    {
        $result = $this->repo->updateSetting($request);
        if ($result) {
            return redirect()->back()->with('success', ___('alert.updated_successfully'));
        }
        return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
    }
}
