<?php

use App\Models\Academic\ClassRoutine;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use App\Models\StudentInfo\SessionClassStudent;

if (!function_exists('verifyUrl')) {
    function verifyUrl($verifier = 'auth')
    {
        $url = config('app.verifier');
        return $url;
    }
}

if (!function_exists('isTestMode')) {
    function isTestMode()
    {
        if (env('APP_DEMO') == true && env('APP_ENV') == 'local') {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('isConnected')) {
    function isConnected()
    {
        $connected = @fsockopen("www.google.com", 80);
        if ($connected) {
            fclose($connected);
            return true;
        }

        return false;
    }
}

if (!function_exists('app_url')) {
    function app_url()
    {
        $saas = config('app.saas_module_name', 'Saas');
        $module_check_function = config('app.module_status_check_function', 'moduleStatusCheck');
        if (function_exists($module_check_function) && $module_check_function($saas)) {
            return config('app.url');
        }
        return url('/');
    }
}

if (!function_exists('curlIt')) {

    function curlIt($url, $postData = array())
    {
        $url = preg_replace("/\r|\n/", "", $url);
        try {
            $response = Http::timeout(3)->acceptJson()->get($url);
            if ($response->successful()) {
                return $response->json();
            }

            return [];
        } catch (\Exception $e) {
        }
        return [
            'goto' => $url . '&from=browser',
        ];
    }
}

if (!function_exists('gv')) {

    function gv($params, $key, $default = null)
    {
        return (isset($params[$key]) && $params[$key]) ? $params[$key] : $default;
    }
}

if (!function_exists('gbv')) {
    function gbv($params, $key)
    {
        return (isset($params[$key]) && $params[$key]) ? 1 : 0;
    }
}

if (!function_exists('AuthPermitCheck')) {
    function AuthPermitCheck()
    {
        $markerFiles = ['.WelcomeNote', '.CheckEnvironment', '.LicenseVerification', '.DatabaseSetup', '.AdminSetup', '.Complete'];

        $allMarkersExist = collect($markerFiles)->every(function ($file) {
            return Storage::disk('local')->exists($file);
        });

        if ($allMarkersExist) {
            return true;
        }

        try {
            if (empty(env('DB_DATABASE')) || empty(env('APP_KEY'))) {
                return false;
            }

            return Schema::hasTable('users') && Schema::hasTable('migrations');
        } catch (\Throwable $e) {
            return false;
        }
    }
}

// allowedUrls
if (!function_exists('allowedUrls')) {
    function allowedUrls()
    {
        $allowedUrls = [
            URL::route('service.install'),
            URL::route('service.checkEnvironment'),
            URL::route('service.license'),
            URL::route('service.license_post'),
            URL::route('service.database'),
            URL::route('service.database_post'),
            URL::route('service.uninstall'),
            URL::route('service.verify'),
            URL::route('service.user'),
            URL::route('service.user_post'),
            URL::route('service.done'),
            URL::route('service.reinstall'),
            URL::route('service.import_sql'),
            URL::route('service.import_sql_post'),
        ];
        return $allowedUrls;
    }
}

if (!function_exists('envu')) {
    function envu($data = array())
    {
        foreach ($data as $key => $value) {
            if (env($key) === $value) {
                unset($data[$key]);
            }
        }

        if (!count($data)) {
            return false;
        }

        // write only if there is change in content

        $env = file_get_contents(base_path() . '/.env');
        $env = explode("\n", $env);
        foreach ((array) $data as $key => $value) {
            foreach ($env as $env_key => $env_value) {
                $entry = explode("=", $env_value, 2);
                if ($entry[0] === $key) {
                    $env[$env_key] = $key . "=" . (is_string($value) ? '"' . $value . '"' : $value);
                } else {
                    $env[$env_key] = $env_value;
                }
            }
        }
        $env = implode("\n", $env);
        file_put_contents(base_path() . '/.env', $env);
        return true;
    }
}

if (!function_exists('formatTimeAMPM')) {
    function formatTimeAMPM($time)
    {
        return \Carbon\Carbon::parse($time)->format('h:i A');
    }
}

if (!function_exists('wordLimit')) {
    function wordLimit($string, $limit)
    {
        $words = explode(' ', $string);
        $limitedWords = array_slice($words, 0, $limit);
        $truncatedString = implode(' ', $limitedWords);

        return $truncatedString;
    }
}

if (!function_exists('addDecimal')) {
    function addDecimal($number)
    {
        return number_format($number, 2);
    }
}