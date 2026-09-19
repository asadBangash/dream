<?php

namespace Modules\MainApp\Http\Repositories;

use App\Models\Setting;
use App\Models\Currency;
use App\Models\Language;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Traits\CommonHelperTrait;
use Modules\MainApp\Http\Interfaces\SettingInterface;

class SettingRepository implements SettingInterface
{
    use CommonHelperTrait;

    private $model;

    public function __construct(Setting $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return Setting::all();
    }

    public function getLanguage()
    {
        return Language::all();
    }

    public function getCurrencies()
    {
        return Currency::get(['code', 'symbol']);
    }

    // General setting start
    public function updateGeneralSetting($request)
    {
        try {
            // Application name start
            if($request->has('application_name')){
                $setting            = $this->model::where('name', 'application_name')->first();
                if($setting){
                    $setting->value = $request->application_name;
                }else{
                    $setting        = new $this->model;
                    $setting->name  = 'application_name';
                    $setting->value = $request->application_name;
                }
                $setting->save();
            }
            // Application name end

            //Footer Text start
            if($request->has('footer_text')){
                $setting            = $this->model::where('name', 'footer_text')->first();
                if($setting){
                    $setting->value = $request->footer_text;
                }else{
                    $setting        = new $this->model;
                    $setting->name  = 'footer_text';
                    $setting->value = $request->footer_text;
                }
                $setting->save();
            }
            //Footer Text end

            //Address start
            if($request->has('address')){
                $setting            = $this->model::where('name', 'address')->first();
                if($setting){
                    $setting->value = $request->address;
                }else{
                    $setting        = new $this->model;
                    $setting->name  = 'address';
                    $setting->value = $request->address;
                }
                $setting->save();
            }
            //Address end

            //Phone start
            if($request->has('phone')){
                $setting            = $this->model::where('name', 'phone')->first();
                if($setting){
                    $setting->value = $request->phone;
                }else{
                    $setting        = new $this->model;
                    $setting->name  = 'phone';
                    $setting->value = $request->phone;
                }
                $setting->save();
            }
            //Phone end

            //Email start
            if($request->has('email')){
                $setting            = $this->model::where('name', 'email')->first();
                if($setting){
                    $setting->value = $request->email;
                }else{
                    $setting        = new $this->model;
                    $setting->name  = 'email';
                    $setting->value = $request->email;
                }
                $setting->save();
            }
            //Email end

            //School about start
            if($request->has('school_about')){
                $setting            = $this->model::where('name', 'school_about')->first();
                if($setting){
                    $setting->value = $request->school_about;
                }else{
                    $setting        = new $this->model;
                    $setting->name  = 'school_about';
                    $setting->value = $request->school_about;
                }
                $setting->save();
            }
            //School about end

            //Defualt language start
            if($request->has('default_langauge')){
                $setting            = $this->model::where('name', 'default_langauge')->first();
                if($setting){
                    $setting->value = $request->default_langauge;
                }else{
                    $setting        = new $this->model;
                    $setting->name  = 'default_langauge';
                    $setting->value = $request->default_langauge;
                }
                Session::put('locale', $request->default_langauge);
                $setting->save();
            }
            //Defualt language end
            //Defualt session start
            if($request->has('session')){
                $setting            = $this->model::where('name', 'session')->first();
                if($setting){
                    $setting->value = $request->session;
                }else{
                    $setting        = new $this->model;
                    $setting->name  = 'session';
                    $setting->value = $request->session;
                }
                $setting->save();
            }
            //Defualt session end

            // White logo start
            if ($request->has('light_logo') && $request->file('light_logo')->isValid()) {
                $setting            = $this->model::where('name', 'light_logo')->first();
                $path               = 'backend/uploads/settings';
                if ($setting) {
                    $file_path          = public_path($setting->value);
                    // if(file_exists($file_path)){
                    //     File::delete($file_path);
                    // }
                    $file               = $request->file('light_logo');
                    $extension          = $file->guessExtension();
                    $filename           = Str::random(6). '_' . time() . '.' . $extension;
                    if (setting('file_system') == 's3') {
                        $filePath       = s3Upload($path, $file);
                        $setting->value = $filePath;
                    }else{
                        $file->move($path, $filename);
                        $setting->value = $path .'/'. $filename;
                    }
                    $setting->save();

                }else {
                    $setting        = new $this->model;
                    $setting->name  = 'light_logo';
                    $file           = $request->file('light_logo');
                    $extension      = $file->guessExtension();
                    $filename       = Str::random(6). '_' . time() . '.' . $extension;
                    if (setting('file_system') == 's3') {
                        $filePath       = s3Upload($path, $file);
                        $setting->value = $filePath;
                    }else{
                        $file->move($path, $filename);
                        $setting->value = $path .'/'. $filename;
                    }
                    $setting->save();
                }
            }
            // White logo end


            if ($request->has('dark_logo') && $request->file('dark_logo')->isValid()) {
                $setting            = $this->model::where('name', 'dark_logo')->first();
                $path               = 'backend/uploads/settings';
                if ($setting) {
                    $file_path = public_path($setting->value);
                    // if(file_exists($file_path)){
                    //     File::delete($file_path);
                    // }
                    $file               = $request->file('dark_logo');
                    $extension          = $file->guessExtension();
                    $filename           = Str::random(6). '_' . time() . '.' . $extension;
                    if (setting('file_system') == 's3') {
                        $filePath       = s3Upload($path, $file);
                        $setting->value = $filePath;
                    }else{
                        $file->move($path, $filename);
                        $setting->value = $path .'/'. $filename;
                    }
                    $setting->save();

                }else {

                    $setting        = new $this->model;
                    $setting->name  = 'dark_logo';
                    $file           = $request->file('dark_logo');
                    $extension      = $file->guessExtension();
                    $filename       = Str::random(6). '_' . time() . '.' . $extension;
                    if (setting('file_system') == 's3') {
                        $filePath       = s3Upload($path, $file);
                        $setting->value = $filePath;
                    }else{
                        $file->move($path, $filename);
                        $setting->value = $path .'/'. $filename;
                    }
                    $setting->save();
                }
            }

            if ($request->has('favicon') && $request->file('favicon')->isValid()) {
                $setting                = $this->model::where('name', 'favicon')->first();
                $path = 'backend/uploads/settings';
                if ($setting) {
                    $file_path          = public_path($setting->value);
                    // if(file_exists($file_path)){
                    //     File::delete($file_path);
                    // }
                    $file               = $request->file('favicon');
                    $extension          = $file->guessExtension();
                    $filename           = Str::random(6). '_' . time() . '.' . $extension;
                    if (setting('file_system') == 's3') {
                        $filePath       = s3Upload($path, $file);
                        $setting->value = $filePath;
                    }else{
                        $file->move($path, $filename);
                        $setting->value = $path .'/'. $filename;
                    }
                    $setting->save();

                }else {
                    $setting            = new $this->model;
                    $setting->name      = 'favicon';
                    $file = $request->file('favicon');
                    $extension          = $file->guessExtension();
                    $filename           = Str::random(6). '_' . time() . '.' . $extension;
                    if (setting('file_system') == 's3') {
                        $filePath       = s3Upload($path, $file);
                        $setting->value = $filePath;
                    }else{
                        $file->move($path, $filename);
                        $setting->value = $path .'/'. $filename;
                    }
                    $setting->save();
                }
            }


            // Currency Code start
            if($request->has('currency_code')){
                $setting            = $this->model::where('name', 'currency_code')->first();
                if($setting){
                    $setting->value = $request->currency_code;
                }else{
                    $setting        = new $this->model;
                    $setting->name  = 'currency_code';
                    $setting->value = $request->currency_code;
                }
                $setting->save();
            }
            // Currency Code end


            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
    // General setting en

}
