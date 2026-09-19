<?php

namespace Modules\MainApp\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Modules\MainApp\Http\Repositories\SettingRepository;
use Modules\MainApp\Http\Requests\Settings\GeneralSettingStoreRequest;

class SettingController extends Controller
{
    private $settingRepo;

    function __construct(SettingRepository $settingRepo)
    {
        if (!Schema::hasTable('settings') && !Schema::hasTable('users')  ) {
            abort(400);
        }
        $this->settingRepo = $settingRepo;
    }

    public function generalSettings()
    {
        $data['title']      = ___('common.general_settings');
        $data['data']       = $this->settingRepo->getAll();
        $data['languages']  = $this->settingRepo->getLanguage();
        $data['currencies'] = $this->settingRepo->getCurrencies();
        return view('mainapp::settings.general-settings', compact('data'));
    }

    public function updateGeneralSetting(GeneralSettingStoreRequest $request)
    {
        $result = $this->settingRepo->updateGeneralSetting($request);
        if ($result) {
            return redirect()->back()->with('success', ___('alert.general_settings_updated_successfully'));
        }
        return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
    }
}
