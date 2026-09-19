<?php

namespace App\Http\Controllers;

use App\Interfaces\SettingInterface;
use Illuminate\Http\Request;

class TaxController extends Controller
{

    private $setting;

    function __construct(SettingInterface $settingInterface){
        $this->setting = $settingInterface;
    }

    public function index(){
        $data['title']       = ___('tax.Tax Setup');
        return view('backend.tax.index', compact('data'));
    }

    public function store(Request $request)
    {

        $result = $this->setting->updateTaxSetting($request);
        if ($result) {
            return redirect()->back()->with('success', ___('alert.updated_successfully'));
        }
        return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
    }
}
