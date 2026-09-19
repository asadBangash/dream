<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class ModuleInstallController extends Controller
{

    public function moduleInstall($moduleName)
    {
        try {
            $exitCode = Artisan::call('module:install', ['module' => $moduleName]);

            if ($exitCode === 0) {
                return redirect()->route("dashboard")->with("success", "$moduleName install successfully.");
            } else {
                return redirect()->route("dashboard")->with("danger", "Failed to install $moduleName.");
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->route("dashboard")->with("danger",  $th->getMessage()."Failed to execute migrations and seeds for module $moduleName.");
        }
    }
}
