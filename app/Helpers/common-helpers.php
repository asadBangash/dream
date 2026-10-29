<?php

use App\Models\Academic\SubjectAssignChildren;
use App\Models\Currency;
use App\Models\Examination\ExaminationSettings;
use App\Models\Examination\MarksGrade;
use App\Models\Language;
use App\Models\Setting;
use App\Models\StudentInfo\SessionClassStudent;
use App\Models\Subscription;
use App\Models\SystemNotification;
use App\Models\Upload;
use App\Models\WebsiteSetup\OnlineAdmissionSetting;
use App\Models\WebsiteSetup\PageSections;
use App\Models\SectionTranslate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\MainApp\Enums\PackagePaymentType;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Twilio\Rest\Client;

function getPagination($ITEM)
{
    return view('common.pagination', compact('ITEM'));
}


function resolveActiveSessionSettingBranchId(): int
{
    if (! hasModule('MultiBranch') || ! auth()->check()) {
        return 1;
    }

    if (isSuperAdmin()) {
        $active = superAdminActiveBranchId();

        return $active ? (int) $active : (int) (\Illuminate\Support\Facades\DB::table('branches')->min('id') ?: 1);
    }

    return (int) (auth()->user()->branch_id ?: 1);
}

function setting($name)
{
    try {
        if ($name == 'currency_symbol') {
            $currencyCode = setting('currency_code');
            return Currency::where('code', $currencyCode)->first()?->symbol;
        }

        if ($name === 'session' && hasModule('MultiBranch')) {
            $branchId = resolveActiveSessionSettingBranchId();
            $setting_data = Setting::query()
                ->where('name', 'session')
                ->where('branch_id', $branchId)
                ->first();

            if (! $setting_data) {
                $setting_data = Setting::query()->where('name', 'session')->orderBy('id')->first();
            }

            if ($setting_data) {
                return $setting_data->value;
            }

            return null;
        }

        $setting_data = Setting::where('name', $name)->first();
        if ($setting_data) {
            return $setting_data->value;
        }

        return null;
    } catch (\Throwable $th) {
        return null;
    }
}

function settingLocale($name)
{
    $setting_data = Setting::where('name', $name)->first();
    if ($setting_data) {
        return @$setting_data->defaultTranslate->value;
    }

    return null;
}

function examSetting($name)
{
    $setting_data = ExaminationSettings::where('name', $name)->where('session_id', setting('session'))->first();
    if ($setting_data) {
        return $setting_data->value;
    }

    return null;
}


function findDirectionOfLang()
{
    $data = Language::where('code', Session::get('locale'))->select('direction')->first();
    return @$data->direction != null ? strtolower(@$data->direction) : '';
}

// for menu active
if (!function_exists('set_menu')) {
    function set_menu(array $path, $active = 'mm-active')
    {
        foreach ($path as $route) {
            if (Route::currentRouteName() == $route) {
                return $active;
            }
        }
        return (request()->is($path)) ? $active : '';
        // return call_user_func_array('Request::is', (array) $path) ? $active : '';
    }
}

// for  submenu list item active
if (!function_exists('menu_active_by_route')) {
    function menu_active_by_route($route)
    {
        return request()->routeIs($route) ? 'mm-show' : 'in-active';
    }
}


// get upload path
if (!function_exists('uploadPath')) {
    function uploadPath($id)
    {
        $row = Upload::find($id);
        return $row->path;
    }
}

if (!function_exists('calculateTax')) {
    function calculateTax($amount)
    {
        static $settings = null;

        if ($settings === null) {
            $settings = Setting::whereIn('name', ['tax_min_amount', 'tax_percentage'])
                ->pluck('value', 'name');
        }

        $tax = 0;

        if (isset($settings['tax_min_amount'], $settings['tax_percentage'])) {
            if ($amount >= $settings['tax_min_amount']) {
                $tax = ($settings['tax_percentage'] / 100) * $amount;
            }
        }

        return $tax;
    }
}

if (!function_exists('calculateDiscount')) {
    function calculateDiscount($amount, $percent)
    {
        return ($amount * $percent) / 100;
    }
}

function ___($key = null, $replace = [], $locale = null)
{
    $input = explode('.', $key);
    $term = $input[1] ?? $key;
    $app_local = Session::get('locale') ?: 'bn';

    try {
        if (str_contains($key, '.')) {
            [$file_name, $trans_key] = explode('.', $key, 2); // allow for multiple dots

            $file_path = base_path('lang/' . $app_local . '/' . $file_name . '.json');
        }

        if (!file_exists($file_path)) {
            file_put_contents($file_path, json_encode([]));
        }

        $file_data = json_decode(file_get_contents($file_path), true) ?? [];

        if (!array_key_exists($trans_key, $file_data)) {
            // Transform: replace underscores and convert to title case
            $default_value = ucwords(str_replace('_', ' ', $trans_key));

            $file_data[$trans_key] = $default_value;
            file_put_contents($file_path, json_encode($file_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }

        return $file_data[$trans_key];
    } catch (\Exception $e) {
        return ucwords(str_replace('_', ' ', $term));
    }
}



// function ___($key = null, $replace = [], $locale = null)
// {

//     $input = explode('.', $key);
//     $file = $input[0];
//     $term = $input[1] ?? '';
//     $app_local = Session::get('locale') ? Session::get('locale') : 'en';
//     $file_path = base_path('lang/' . $app_local . '/' . $file . '.json');
//     $term = str_replace('_', ' ', $term);

//     if (!is_dir(dirname($file_path))) {
//         mkdir(dirname($file_path), 0777, true);
//     }
//     if (!file_exists($file_path)) {
//         $data = [];
//         file_put_contents($file_path, json_encode($data, JSON_UNESCAPED_UNICODE));
//     }

//     $jsonString = file_get_contents($file_path);
//     $data = json_decode($jsonString, true);

//     if (@$data[$term]) {
//         return $data[$term];
//     } else {
//         $data[$term] = $term;
//         file_put_contents($file_path, json_encode($data, JSON_UNESCAPED_UNICODE));
//     }

//     return $term;
// }

// global thumbnails
if (!function_exists('globalAsset')) {
    function globalAsset($path, $default_image = null)
    {
        if ($path == "") {
            return url("backend/uploads/default-images/$default_image");
        } else {
            try {
                if (setting('file_system') == "s3" && Storage::disk('s3')->exists($path) && $path != "") {
                    return Storage::disk('s3')->url($path);
                } else if (setting('file_system') == "local" && $path != "" && file_exists(public_path($path))) {
                    return url($path);
                } else {
                    if ($default_image == null) {
                        return url('backend/uploads/default-images/user2.jpg');
                    } else {
                        return url("backend/uploads/default-images/$default_image");
                    }
                }
            } catch (\Exception $c) {
                return url("backend/uploads/default-images/$default_image");
            }
        }
    }
}

if (! function_exists('frontendLocale')) {
    function frontendLocale(): string
    {
        return request()->locale ?? app()->getLocale();
    }
}

if (! function_exists('normalizeExternalUrl')) {
    function normalizeExternalUrl(?string $url): string
    {
        $url = trim((string) $url);
        if ($url === '' || $url === '#') {
            return '#';
        }
        if (preg_match('#^(https?://|mailto:|tel:|whatsapp:)#i', $url)) {
            return $url;
        }

        return 'https://'.ltrim($url, '/');
    }
}

if (! function_exists('resolveDefaultTranslate')) {
    /** Pick locale translation with English fallback; sets defaultTranslate relation when possible. */
    function resolveDefaultTranslate(?Model $model): ?Model
    {
        if ($model === null) {
            return null;
        }

        if ($model->relationLoaded('defaultTranslate') && $model->getRelation('defaultTranslate')) {
            return $model->getRelation('defaultTranslate');
        }

        if (! method_exists($model, 'translations')) {
            return null;
        }

        if (! $model->relationLoaded('translations')) {
            $model->load('translations');
        }

        $locale = frontendLocale();
        $translate = $model->translations->firstWhere('locale', $locale)
            ?? $model->translations->firstWhere('locale', 'en');

        if ($model instanceof PageSections) {
            if (! $translate) {
                $translate = new SectionTranslate([
                    'name' => $model->name,
                    'description' => $model->description,
                    'data' => is_array($model->data) ? $model->data : [],
                    'locale' => $locale,
                ]);
            } else {
                if (blank($translate->name) && filled($model->name)) {
                    $translate->name = $model->name;
                }
                if (blank($translate->description) && filled($model->description)) {
                    $translate->description = $model->description;
                }
                $translateData = $translate->data ?? null;
                if ((! is_array($translateData) || $translateData === []) && is_array($model->data) && $model->data !== []) {
                    $translate->data = $model->data;
                }
            }
        }

        $model->setRelation('defaultTranslate', $translate);

        return $translate;
    }
}

if (! function_exists('sectionTranslateData')) {
    /** @return array<int, mixed> */
    function sectionTranslateData(?PageSections $section): array
    {
        if ($section === null) {
            return [];
        }

        resolveDefaultTranslate($section);
        $data = $section->defaultTranslate?->data ?? null;
        if (is_array($data) && $data !== []) {
            return $data;
        }

        $fallback = $section->data ?? [];

        return is_array($fallback) ? $fallback : [];
    }
}

if (! function_exists('hydratePageSectionsForFrontend')) {
    /** @param iterable<int, PageSections> $sections */
    function hydratePageSectionsForFrontend(iterable $sections): array
    {
        $sectionArr = [];
        foreach ($sections as $section) {
            resolveDefaultTranslate($section);
            $sectionArr[$section->key] = $section;
        }

        return $sectionArr;
    }
}

if (! function_exists('hydrateTranslatableCollection')) {
    /**
     * @param  Collection|AbstractPaginator|array<int, Model>  $items
     * @return Collection|AbstractPaginator|array<int, Model>
     */
    function hydrateTranslatableCollection($items)
    {
        if ($items instanceof AbstractPaginator) {
            $items->through(function ($model) {
                resolveDefaultTranslate($model);

                return $model;
            });

            return $items;
        }

        foreach ($items as $model) {
            resolveDefaultTranslate($model);
        }

        return $items;
    }
}

if (! function_exists('publicAssetVersion')) {
    /** Public file URL with ?v=filemtime so CSS/JS refresh after deploy (not Laravel view cache). */
    function publicAssetVersion(string $path): string
    {
        $path = ltrim(str_replace('\\', '/', $path), '/');
        $absolute = public_path($path);
        $url = url($path);

        if (is_file($absolute)) {
            return $url.'?v='.filemtime($absolute);
        }

        return $url;
    }
}


// Permission check
if (!function_exists('hasPermission')) {
    function hasPermission($keyword)
    {
        if (Auth::check() && Auth::user()->role_id == 1) {
            return true;
        }
        if (in_array($keyword, Auth::user()->permissions ?? [])) {
            return true;
        }
        return false;
    }
}


// Date format
if (!function_exists('dateFormat')) {
    function dateFormat($keyword)
    {
        return date('d M Y', strtotime($keyword));
    }
}
if (!function_exists('timeFormat')) {
    function timeFormat($keyword)
    {
        return date('g:i A', strtotime($keyword));
    }
}
// Mark grade
if (!function_exists('markGrade')) {
    function markGrade($data)
    {
        $result = MarksGrade::where('session_id', setting('session'))->where('percent_upto', '>=', $data)->where('percent_from', '<=', $data)->first();
        if ($result) {
            return $result->name;
        }
        return '...';
    }
}

if (!function_exists('userTheme')) {
    function userTheme()
    {
        $session_theme = Session::get('user_theme');

        if (isset($session_theme)) {
            return $session_theme;
        } else {
            return 'default-theme';
        }
    }
}

if (!function_exists('leadingZero')) {
    function withLeadingZero($number)
    {

        // $strNumber = $number;
        // if(strlen($strNumber) < 10){
        //     return $strNumber;
        // }

        return $number;
    }
}


if (!function_exists('setEnvironmentValue')) {
    function setEnvironmentValue($envKey, $envValue)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        $str .= "\n"; // In case the searched variable is in the last line without \n
        $keyPosition = strpos($str, "{$envKey}=");
        $endOfLinePosition = strpos($str, PHP_EOL, $keyPosition);
        $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
        $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
        $str = substr($str, 0, -1);

        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);
    }
}

if (!function_exists('s3Upload')) {
    function s3Upload($directory, $file)
    {
        $directory = 'public/' . $directory;
        return Storage::disk('s3')->put($directory, $file, 'public');
    }
}

if (!function_exists('s3ObjectCheck')) {
    function s3ObjectCheck($path)
    {
        return Storage::disk('s3')->exists($path);
    }
}


if (!function_exists('include_route_files')) {
    /**
     * Loops through a folder and requires all PHP files
     * Searches sub-directories as well.
     *
     * @param $folder
     */
    function include_route_files($folder)
    {
        try {
            $rdi = new RecursiveDirectoryIterator($folder);
            $it = new RecursiveIteratorIterator($rdi);

            while ($it->valid()) {
                if (!$it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php') {
                    require $it->key();
                }

                $it->next();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    function getAllDaysInMonth($year, $month)
    {
        $daysInMonth = Carbon::create($year, $month)->daysInMonth;
        $days = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($year, $month, $day);
            $days[] = $date->format('Y-m-d');
        }

        return $days;
    }


    function getSubdomainName()
    {
        $parsedUrl = parse_url(url()->full());
        $hostParts = explode('.', $parsedUrl['host']);
        return $hostParts;
    }
}

if (!function_exists('saasMiddleware')) {
    function saasMiddleware()
    {


        if (env('APP_SAAS')) {
            return [
                'web',
                InitializeTenancyByDomain::class,
                PreventAccessFromCentralDomains::class,
            ];
        }

        return [
            'web'
        ];
    }
}

if (!function_exists('saasApiMiddleware')) {
    function saasApiMiddleware()
    {

        if (env('APP_SAAS')) {
            return [
                'api',
                InitializeTenancyByDomain::class,
                PreventAccessFromCentralDomains::class,
            ];
        }

        return [
            'api'
        ];
    }
}


function activeSubscriptionStudentLimit()
{
    if (env('APP_SAAS')) {
        return cache()->rememberForever('activeSubscriptionStudentLimit', function () {
            $subscription = Subscription::active()->first();

            if ($subscription) {
                return $subscription->payment_type == PackagePaymentType::PREPAID ? $subscription->student_limit : 99999999;
            }

            return null;
        });
    }

    return null;
}

function activeSubscriptionStaffLimit()
{
    if (env('APP_SAAS')) {
        return cache()->rememberForever('activeSubscriptionStaffLimit', function () {
            $subscription = Subscription::active()->first();

            if ($subscription) {
                return $subscription->payment_type == PackagePaymentType::PREPAID ? $subscription->staff_limit : 99999999;
            }

            return null;
        });
    }

    return null;
}

function activeSubscriptionExpiryDate()
{
    if (env('APP_SAAS')) {
        return cache()->rememberForever('activeSubscriptionExpiryDate', function () {
            $subscription = Subscription::active()->first();
            if ($subscription) {
                if ($subscription->expiry_date) { // expiry gate null menas this is lifetime package
                    if (date('Y-m-d') <= date('Y-m-d', strtotime($subscription->expiry_date))) {
                        return true;
                    }
                    return false;
                }
                return true;
            }
            return false;
        });
    }
    return true;
}

function activeSubscriptionFeatures()
{
    if (env('APP_SAAS')) {
        return cache()->rememberForever('activeSubscriptionFeatures', function () {
            return Subscription::active()->first()?->features;
        });
    }

    return null;
}


// Feature check
if (!function_exists('hasFeature')) {
    function hasFeature($keyword)
    {
        if (!env('APP_SAAS')) {
            return true;
        }
        // if (in_array($keyword, Setting('features') ?? [])) {
        if (in_array($keyword, activeSubscriptionFeatures() ?? [])) {
            return true;
        }
        return false;
    }
}


function sessionClassStudent()
{

    $sesionClassStudent = SessionClassStudent::query()
        ->where('student_id', request()->filled('student_id') ? request('student_id') : @auth()->user()->student->id)
        ->first();

    if ($sesionClassStudent) {
        return $sesionClassStudent;
    }

    if (sessionClassStudentByParent()) {
        return sessionClassStudentByParent();
    }

    if (isStudentAccessInAPI()) {
        $data = SessionClassStudent::query()
            ->where('student_id', request()->filled('student_id') ? request('student_id') : @auth()->user()->student->id)
            ->whereHas('session', function ($q) {
                $q->whereYear('start_date', '<=', date('Y'))
                    ->whereYear('end_date', '>=', date('Y'));
            })->first();

        return $data;
    }

    return null;
}


function getDayNum($date)
{
    $day = Str::lower(Carbon::createFromFormat('Y-m-d', $date)->format('l'));

    switch ($day) {
        case $day == 'saturday':
            return 1;
            break;
        case $day == 'sunday':
            return 2;
            break;
        case $day == 'monday':
            return 3;
            break;
        case $day == 'tuesday':
            return 4;
            break;
        case $day == 'wednesday':
            return 5;
            break;
        case $day == 'thursday':
            return 6;
            break;
        default:
            return 7;
    }
}


function loadPayPalCredentials()
{
    if (Str::lower(Setting('paypal_payment_mode')) == 'sandbox') {
        \Config::set('paypal.sandbox.username', Setting('paypal_sandbox_api_username'));
        \Config::set('paypal.sandbox.password', Setting('paypal_sandbox_api_password'));
        \Config::set('paypal.sandbox.secret', Setting('paypal_sandbox_api_secret'));
        \Config::set('paypal.sandbox.certificate', Setting('paypal_sandbox_api_certificate'));
    } elseif (Str::lower(Setting('paypal_payment_mode')) == 'live') {
        \Config::set('paypal.live.username', Setting('paypal_live_api_username'));
        \Config::set('paypal.live.password', Setting('paypal_live_api_password'));
        \Config::set('paypal.live.secret', Setting('paypal_live_api_secret'));
        \Config::set('paypal.live.certificate', Setting('paypal_live_api_certificate'));
    }
}


function teacherSubjects()
{
    $staffId = authStaffId();

    return SubjectAssignChildren::with('subject')
        ->when(Auth::user()->role_id == 5 && $staffId, function ($query) use ($staffId) {
            return $query->where('staff_id', $staffId);
        })
        ->pluck('subject_id')
        ->toArray();
}


if (!function_exists('getAttendanceType')) {

    function getAttendanceType($type)
    {
        if ($type == 1) {
            return 'PRESENT';
        } elseif ($type == 2) {
            return 'LATE';
        } elseif ($type == 3) {
            return 'ABSENT';
        } elseif ($type == 4) {
            return 'HALFDAY';
        } else {
            return '';
        }
    }
}


if (!function_exists('send_web_notification')) {
    function send_web_notification($title, $message, $reciever_id, $url = null)
    {
        try {
            $notification = new SystemNotification();
            $notification->title = $title;
            $notification->message = $message;
            $notification->reciver_id = $reciever_id;
            $notification->url = $url;
            $notification->save();
        } catch (\Throwable $th) {
            Log::info('NOtification store::' . $th);
        }
    }
}

if (!function_exists('send_message')) {
    function send_message_twillo($message, $recipients)
    {
        Log::info('To Number ::' . $recipients . 'Message::  ' . $message);
        try {
            $sid = setting('twilio_account_sid');
            $token = setting('twilio_auth_token');
            $twilio_number = setting('twilio_phone_number');

            if ($sid && $token && $twilio_number) {
                $twilio = new Client($sid, $token);
                return $twilio->messages
                    ->create(
                        $recipients,
                        [
                            "body" => $message,
                            "from" => $twilio_number
                        ]
                    );
            }
        } catch (\Throwable $th) {
            Log::info('Twillo Msg Error' . $th->getMessage());
        }
    }
}


if (!function_exists('send_flutter_notification')) {
    function send_flutter_notification($title, $message, $img = null)
    {

        try {
            $url = 'https://fcm.googleapis.com/fcm/send';
            $dataArr = array('click_action' => 'FLUTTER_NOTIFICATION_CLICK', 'status' => "done");
            $notification = array('title' => $title, 'text' => $message, 'image' => $img, 'sound' => 'default', 'badge' => '1',);
            $arrayToSend = array('notification' => $notification, 'data' => $dataArr, 'priority' => 'high');
            $fields = json_encode($arrayToSend);
            $headers = array(
                'Authorization: key=' . setting('FCM_SECRET_KEY'),
                'Content-Type: application/json'
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            $result = curl_exec($ch);
            curl_close($ch);
        } catch (\Throwable $th) {
            Log::info('Flutter Push Msg Error' . $th->getMessage());
        }
    }
}

function getAttendanceType($type)
{
    if ($type == 1) {
        return 'PRESENT';
    } elseif ($type == 2) {
        return 'LATE';
    } elseif ($type == 3) {
        return 'ABSENT';
    } elseif ($type == 4) {
        return 'HALFDAY';
    } else {
        return '';
    }
}


function send_web_notification($title, $message, $reciever_id, $url = null)
{
    try {
        $notification = new SystemNotification();
        $notification->title = $title;
        $notification->message = $message;
        $notification->reciver_id = $reciever_id;
        $notification->url = $url;
        $notification->save();
    } catch (\Throwable $th) {
        Log::info('NOtification store::' . $th);
        //   Log::info($th->getMessage());
    }
}

if (!function_exists('hasModule')) {
    function hasModule($name): bool
    {
        $filePath = base_path('modules_statuses.json');
        $statuses = json_decode(file_get_contents($filePath), true);
        if (isset($statuses[$name])) {
            $isModuleEnabled = $statuses[$name];
            if ($isModuleEnabled) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

if (!function_exists('isSuperAdmin')) {
    function isSuperAdmin()
    {
        $role = auth()->user()?->role_id;
        if ($role == \App\Enums\RoleEnum::SUPERADMIN) {
            return true;
        }
        return false;
    }
}

if (! function_exists('isBranchAdmin')) {
    function isBranchAdmin(): bool
    {
        return auth()->check()
            && auth()->user()->role_id === \App\Enums\RoleEnum::ADMIN;
    }
}

if (! function_exists('centralAcademicTables')) {
    /** Tables whose academic configuration is shared across all branches. */
    function centralAcademicTables(): array
    {
        return [
            'sessions',
            'session_translates',
            'classes',
            'class_translates',
            'sections',
            'section_translates',
            'class_section_translates',
            'shifts',
            'shift_translates',
            'subjects',
            'class_setups',
            'class_setup_childrens',
            'subject_assigns',
            'subject_assign_childrens',
            'time_schedules',
            'class_rooms',
        ];
    }
}

if (! function_exists('authStaffId')) {
    /** Staff row id for the logged-in user (ignores branch scope on staff). */
    function authStaffId(): ?int
    {
        if (! auth()->check()) {
            return null;
        }

        $id = \App\Models\Staff\Staff::withoutGlobalScopes()
            ->where('user_id', auth()->id())
            ->value('id');

        return $id ? (int) $id : null;
    }
}

if (! function_exists('isCentralAcademicTable')) {
    function isCentralAcademicTable(string $table): bool
    {
        return in_array($table, centralAcademicTables(), true);
    }
}

if (! function_exists('canManageCentralAcademicSetup')) {
    /** Super Admin owns global academic setup when MultiBranch is enabled. */
    function canManageCentralAcademicSetup(): bool
    {
        if (! hasModule('MultiBranch')) {
            return true;
        }

        return isSuperAdmin();
    }
}

if (! function_exists('branchIdMeansAllBranches')) {
    function branchIdMeansAllBranches(mixed $value): bool
    {
        if ($value === null || $value === '') {
            return false;
        }

        return in_array((string) $value, ['all', '0'], true);
    }
}

if (! function_exists('allBranchesLabel')) {
    function allBranchesLabel(): string
    {
        return ___('common.All Branches') ?: 'All Branches';
    }
}

if (! function_exists('superAdminActiveBranchId')) {
    /** Super Admin session filter: null = all branches. */
    function superAdminActiveBranchId(): ?int
    {
        if (! isSuperAdmin()) {
            return null;
        }

        $id = session('active_branch_id');

        if ($id === null || $id === '' || $id === 'all' || (int) $id === 0) {
            return null;
        }

        return (int) $id;
    }
}

if (! function_exists('effectiveBranchScopeId')) {
    /** Branch ID applied to queries for the current user. */
    function effectiveBranchScopeId(): ?int
    {
        if (! auth()->check() || ! hasModule('MultiBranch')) {
            return null;
        }

        if (isSuperAdmin()) {
            return superAdminActiveBranchId();
        }

        $branchId = auth()->user()->branch_id ?? null;

        return $branchId ? (int) $branchId : null;
    }
}

if (! function_exists('authorizeBranchId')) {
    function authorizeBranchId(?int $branchId): void
    {
        if (! hasModule('MultiBranch') || ! auth()->check() || $branchId === null) {
            return;
        }

        if (isSuperAdmin()) {
            if (request()->filled('branch_id')) {
                return;
            }
            $active = superAdminActiveBranchId();
            if ($active === null || (int) $branchId === $active) {
                return;
            }
            abort(403, 'Unauthorized branch access.');
        }

        if ((int) $branchId !== (int) auth()->user()->branch_id) {
            abort(403, 'Unauthorized branch access.');
        }
    }
}

if (! function_exists('resolveBranchIdForValidation')) {
    /**
     * Branch context for scoped unique rules and create forms.
     */
    function resolveBranchIdForValidation(?int $recordId = null, ?string $table = null): int
    {
        if (! hasModule('MultiBranch') || ! auth()->check()) {
            return 1;
        }

        if (! isSuperAdmin()) {
            return (int) auth()->user()->branch_id;
        }

        if (request()->has('branch_id') && branchIdMeansAllBranches(request('branch_id'))) {
            return 0;
        }

        if (request()->filled('branch_id')) {
            return (int) request('branch_id');
        }

        if ($recordId && $table && \Illuminate\Support\Facades\Schema::hasTable($table)) {
            $row = \Illuminate\Support\Facades\DB::table($table)->where('id', $recordId)->first(['branch_id']);
            if ($row && $row->branch_id) {
                return (int) $row->branch_id;
            }
        }

        $active = superAdminActiveBranchId();

        return $active ? (int) $active : 0;
    }
}

if (! function_exists('branchIdValidationRules')) {
    /** Validation rules for branch_id on create forms (Super Admin must pick a branch or all). */
    function branchIdValidationRules(bool $forCreate = true, bool $allowAllBranches = false): array
    {
        if (! $forCreate || ! hasModule('MultiBranch') || ! auth()->check()) {
            return [];
        }

        if (isSuperAdmin()) {
            if ($allowAllBranches) {
                return [
                    'branch_id' => [
                        'required',
                        function (string $attribute, mixed $value, \Closure $fail): void {
                            if (branchIdMeansAllBranches($value)) {
                                return;
                            }
                            if (! \Illuminate\Support\Facades\Schema::hasTable('branches')
                                || ! \Illuminate\Support\Facades\DB::table('branches')->where('id', (int) $value)->exists()) {
                                $fail(___('branch.select_branch'));
                            }
                        },
                    ],
                ];
            }

            return [
                'branch_id' => ['required', 'integer', 'exists:branches,id'],
            ];
        }

        return [];
    }
}

if (! function_exists('defaultOperationalBranchId')) {
    /** First active branch — used for staff, students, and other branch-scoped records (never 0). */
    function defaultOperationalBranchId(): int
    {
        if (! hasModule('MultiBranch')) {
            return 1;
        }

        if (\Illuminate\Support\Facades\Schema::hasTable('branches')) {
            $id = (int) \Illuminate\Support\Facades\DB::table('branches')
                ->where('status', \App\Enums\Status::ACTIVE)
                ->orderBy('id')
                ->value('id');
            if ($id > 0) {
                return $id;
            }
        }

        return 1;
    }
}

if (! function_exists('staffBranchIdForPersist')) {
    /** Staff/users must belong to one branch; shared (0) is invalid for login and branch middleware. */
    function staffBranchIdForPersist($request, ?int $existingBranchId = null): int
    {
        $branchId = branchIdForPersist($request);

        if ($branchId > 0) {
            return $branchId;
        }

        if ($existingBranchId !== null && $existingBranchId > 0) {
            return $existingBranchId;
        }

        return defaultOperationalBranchId();
    }
}

if (! function_exists('branchIdForPersist')) {
    function branchIdForPersist($request): int
    {
        if (! hasModule('MultiBranch')) {
            return 1;
        }

        if (isSuperAdmin()) {
            if ($request->has('branch_id') && branchIdMeansAllBranches($request->input('branch_id'))) {
                return 0;
            }
            if ($request->filled('branch_id')) {
                return (int) $request->branch_id;
            }
            $active = superAdminActiveBranchId();

            return $active ? (int) $active : 0;
        }

        return (int) (auth()->user()->branch_id ?: 1);
    }
}

if (! function_exists('applyBranchIdToModel')) {
    /** Assign branch_id when the table has the column (safe if migrations lag on live). */
    function applyBranchIdToModel(\Illuminate\Database\Eloquent\Model $model, int $branchId): void
    {
        if (! hasModule('MultiBranch')) {
            return;
        }

        if (! \Illuminate\Support\Facades\Schema::hasColumn($model->getTable(), 'branch_id')) {
            return;
        }

        // 0 = all branches (column is NOT NULL on most tenant tables).
        $model->branch_id = $branchId > 0 ? $branchId : 0;
    }
}

if (! function_exists('applyRequestBranchToModel')) {
    /** Set branch_id from the current request (Super Admin: branch or all branches). */
    function applyRequestBranchToModel(\Illuminate\Database\Eloquent\Model $model): void
    {
        if (! hasModule('MultiBranch')
            || ! auth()->check()
            || ! \Illuminate\Support\Facades\Schema::hasColumn($model->getTable(), 'branch_id')) {
            return;
        }

        if (request()->has('branch_id')) {
            applyBranchIdToModel($model, branchIdForPersist(request()));

            return;
        }

        if (empty($model->branch_id)) {
            $branchId = effectiveBranchScopeId();
            if ($branchId) {
                $model->branch_id = (int) $branchId;
            }
        }
    }
}

if (! function_exists('branchIdFromClassRequest')) {
    /** Branch for public forms (no logged-in user): derive from selected class. */
    function branchIdFromClassRequest($request): int
    {
        if (! hasModule('MultiBranch')) {
            return 1;
        }

        if (isCentralAcademicTable('classes')) {
            if ($request->filled('branch_id')) {
                return (int) $request->branch_id;
            }

            return 1;
        }

        if ($request->filled('class') && \Illuminate\Support\Facades\Schema::hasTable('classes')) {
            $classBranch = (int) (\App\Models\Academic\Classes::withoutGlobalScopes()
                ->where('id', $request->class)
                ->value('branch_id') ?? 0);

            if ($classBranch > 0) {
                return $classBranch;
            }
        }

        return 1;
    }
}

if (! function_exists('branchIdForStudentPersist')) {
    /**
     * Prefer the enrolled class branch (most reliable for branch admins).
     */
    function branchIdForStudentPersist($request): int
    {
        if (! hasModule('MultiBranch')) {
            return 1;
        }

        $branchId = branchIdForPersist($request);

        if (! isCentralAcademicTable('classes')
            && $request->filled('class')
            && \Illuminate\Support\Facades\Schema::hasTable('classes')) {
            $classBranch = (int) (\App\Models\Academic\Classes::withoutGlobalScopes()
                ->where('id', $request->class)
                ->value('branch_id') ?? 0);

            if ($classBranch > 0) {
                if (! isSuperAdmin() && (int) auth()->user()->branch_id !== $classBranch) {
                    abort(403, 'Selected class does not belong to your branch.');
                }
                $branchId = $classBranch;
            }
        }

        if ($branchId < 1) {
            $branchId = (int) (auth()->user()->branch_id ?? 1);
        }

        return $branchId;
    }
}


if (!function_exists('admission_fields')) {
    function admission_fields()
    {
        // dd(OnlineAdmissionSetting::where('type', 'online_admission')->where('is_show',1)->get()->pluck('field')->values(),2);
        try {
            if (Cache::has('online_admission_field_is_show') && Cache::get('online_admission_field_is_show')) {
                return Cache::get('online_admission_field_is_show');
            }
            return Cache::rememberForever('online_admission_setting', function () {
                return OnlineAdmissionSetting::where('type', 'online_admission')->where('is_show', 1)->get()->pluck(['field'])->toArray();
            });
        } catch (\Throwable $th) {
            return [];
        }
    }
}

if (!function_exists('is_show')) {
    function is_show($field)
    {
        try {
            $field_array = admission_fields();
            return in_array($field, $field_array);
        } catch (\Throwable $th) {
            dd($th);
            return false;
        }
    }
}

if (!function_exists('is_required')) {
    function is_required($field)
    {
        try {
            $field_array = admission_required_fields();
            return in_array($field, $field_array);
        } catch (\Throwable $th) {
            return false;
        }
    }
}

if (!function_exists('admission_required_fields')) {
    function admission_required_fields()
    {
        try {
            if (Cache::has('online_admission_field_is_require') && Cache::get('online_admission_field_is_require')) {
                return Cache::get('online_admission_field_is_require');
            }
            return Cache::rememberForever('online_admission_field_is_require', function () {
                return OnlineAdmissionSetting::where('type', 'online_admission')->where('is_required', 1)->get()->pluck(['field'])->toArray();
            });
        } catch (\Throwable $th) {
            return [];
        }
    }
}


if (!function_exists('app_translate')) {
    function app_translate()
    {
        try {
            return env('APP_TRANSLATE');
        } catch (\Throwable $th) {
            return false;
        }
    }
}


if (!function_exists('isParentUserAccessStudentInAPI')) {
    function isParentUserAccessStudentInAPI()
    {
        return auth()->check() &&
            @auth()->user()->role_id == 7 &&
            request()->filled('student_id')
            ? true : false;
    }
}


if (!function_exists('isStudentAccessInAPI')) {
    function isStudentAccessInAPI()
    {
        return !isParentUserAccessStudentInAPI() &&
            (
                (auth()->check() && @auth()->user()->role_id == 6) ||
                request()->filled('student_id')
            )
            ? true : false;
    }
}


if (!function_exists('sessionClassStudentByParent')) {
    function sessionClassStudentByParent()
    {

        return SessionClassStudent::query()
            ->where('student_id', request('student_id'))
            ->whereHas('student', fn($q) => $q->where('parent_guardian_id', @auth()->user()->parent->id))
            ->whereHas('session', function ($q) {
                $q->whereYear('start_date', '<=', date('Y'))
                    ->whereYear('end_date', '>=', date('Y'));
            })
            ->first();
    }
}

// encrypt id
if (!function_exists('encryptFunction')) {
    function encryptFunction($number = null)
    {

        return openssl_encrypt($number, "AES-128-CTR", "CodeSpeedyKeybj54HH", 0, '8565825542115032');
    }
};

// decrypt id
if (!function_exists('decryptFunction')) {
    function decryptFunction($encrypted = null)
    {
        return openssl_decrypt($encrypted, "AES-128-CTR", "CodeSpeedyKeybj54HH", 0, '8565825542115032');
    }
};


if (!function_exists('humanReadableDate')) {
    function humanReadableDate($date)
    {
        $date = Carbon::parse($date);

        // Check if the date is within one day
        if ($date->diffInDays() >= 1) {
            // Show in a standard date format (e.g., 'Y-m-d H:i:s')
            $formattedDate = $date->format('jS F Y h:i A');
        } else {
            // Show human-readable time difference (e.g., '2 hours ago')
            $formattedDate = $date->diffForHumans();
        }

        return $formattedDate;
    }
};


if (!function_exists('saasTenantMigrationPaths')) {
    function saasTenantMigrationPaths()
    {
        $filePath = base_path('modules_statuses.json');
        $migrationPaths = [
            database_path('migrations/tenant') // Core tenant migrations
        ];

        if (file_exists($filePath)) {
            $json_content = file_get_contents($filePath);
            $modules = json_decode($json_content, true);

            // Exclude MainApp and Installer
            unset($modules["MainApp"]);
            unset($modules["Installer"]);

            // Loop through only enabled (true) modules
            foreach ($modules as $module => $status) {
                if ($status === true) {
                    $migrationPaths[] = base_path("Modules/$module/Database/Migrations");
                }
            }
        }

        return $migrationPaths;
    }
}

if (! function_exists('certificateSchoolLocation')) {
    function certificateSchoolLocation(): string
    {
        $address = (string) setting('address');
        if ($address !== '' && preg_match('/nahaqi/i', $address)) {
            return 'Nahaqi';
        }

        return 'Nahaqi';
    }
}

if (! function_exists('replaceCertificatePlaceholders')) {
    function replaceCertificatePlaceholders(string $text, $sessionStudent, ?string $sessionName = null): string
    {
        if (! $sessionStudent) {
            return $text;
        }

        $sessionStudent->loadMissing(['student.parent', 'class', 'section']);
        $student = $sessionStudent->student;
        $parent = $student?->parent;
        $fatherOrGuardian = trim((string) ($parent?->father_name ?? $parent?->guardian_name ?? ''));

        $className = $sessionStudent->class?->name ?? '';
        $sectionName = $sessionStudent->section?->name ?? '';

        $replacements = [
            '[student_name]' => trim(($student?->first_name ?? '').' '.($student?->last_name ?? '')),
            '[class_name]' => $className,
            '[section_name]' => $sectionName,
            '[course_name]' => $className,
            '[level]' => $sectionName,
            '[father_name]' => $fatherOrGuardian,
            '[parent_line]' => $fatherOrGuardian !== '' ? 'D/o '.$fatherOrGuardian : '',
            '[school_name]' => setting('application_name'),
            '[school_address]' => setting('address'),
            '[school_location]' => certificateSchoolLocation(),
            '[session]' => $sessionName ?? '',
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $text);
    }
}

if (! function_exists('certificateDreamContext')) {
    /** @return array<string, mixed> */
    function certificateDreamContext($certificate, $sessionStudent = null, ?string $sessionName = null, bool $preview = false): array
    {
        $logoUrl = globalAsset(setting('dark_logo'), '154X38.webp');
        $defaultInstitute = 'at The Dream Tuition Academy, '.certificateSchoolLocation().'.';
        $defaultTagline = 'Keep Learning, Keep Growing!';

        if (! $certificate) {
            return [
                'student_name' => '',
                'parent_line' => '',
                'course_name' => '',
                'level' => '',
                'institute_line' => $defaultInstitute,
                'tagline' => $defaultTagline,
                'show_name' => true,
                'show_logo' => true,
                'logo_url' => $logoUrl,
                'school_name' => settingLocale('application_name') ?: 'DREAM TUITION ACADEMY',
            ];
        }

        if ($preview || ! $sessionStudent) {
            $previewCourse = trim((string) $certificate->title);
            $previewLevel = trim((string) $certificate->top_text);
            if ($previewCourse === '' || str_contains($previewCourse, '[')) {
                $previewCourse = 'ENGLISH LANGUAGE';
            }
            if ($previewLevel === '' || str_contains($previewLevel, '[')) {
                $previewLevel = 'LEVEL 3';
            }

            return [
                'student_name' => 'Wafa Bibi',
                'parent_line' => 'D/o Orangzaib',
                'course_name' => $previewCourse,
                'level' => $previewLevel,
                'institute_line' => $certificate->bottom_right_text ?: $defaultInstitute,
                'tagline' => $certificate->bottom_left_text ?: $defaultTagline,
                'show_name' => (bool) $certificate->name,
                'show_logo' => (bool) $certificate->logo,
                'logo_url' => $logoUrl,
                'school_name' => settingLocale('application_name') ?: 'DREAM TUITION ACADEMY',
            ];
        }

        $parentTemplate = trim(strip_tags((string) $certificate->description));
        if ($parentTemplate === '') {
            $parentTemplate = 'D/o [father_name]';
        }
        $parentLine = replaceCertificatePlaceholders($parentTemplate, $sessionStudent, $sessionName);

        return [
            'student_name' => replaceCertificatePlaceholders('[student_name]', $sessionStudent, $sessionName),
            'parent_line' => $parentLine,
            'course_name' => replaceCertificatePlaceholders((string) $certificate->title, $sessionStudent, $sessionName),
            'level' => replaceCertificatePlaceholders((string) $certificate->top_text, $sessionStudent, $sessionName),
            'institute_line' => replaceCertificatePlaceholders(
                $certificate->bottom_right_text ?: $defaultInstitute,
                $sessionStudent,
                $sessionName
            ),
            'tagline' => $certificate->bottom_left_text ?: $defaultTagline,
            'show_name' => (bool) $certificate->name,
            'show_logo' => (bool) $certificate->logo,
            'logo_url' => $logoUrl,
            'school_name' => settingLocale('application_name') ?: 'DREAM TUITION ACADEMY',
        ];
    }
}

if (! function_exists('idCardIsTeacher')) {
    function idCardIsTeacher($idCard): bool
    {
        return ($idCard->card_type ?? \App\Enums\IdCardType::STUDENT) === \App\Enums\IdCardType::TEACHER;
    }
}

if (! function_exists('idCardTemplateImageUrl')) {
    function idCardTemplateImageUrl($idCard): string
    {
        if ($idCard instanceof \App\Models\IdCard) {
            $idCard->loadMissing('frontendBg');
        }

        $bgId = data_get($idCard, 'frontside_bg_image');
        $bgPath = data_get($idCard, 'frontendBg.path');

        if ($bgId && $bgPath) {
            return globalAsset($bgPath, '800X800.webp');
        }

        $file = idCardIsTeacher($idCard)
            ? 'dream-teacher-id-card.png'
            : 'dream-student-id-card.png';

        return asset('backend/uploads/idcard-templates/'.$file);
    }
}

if (! function_exists('idCardFieldValue')) {
    function idCardFieldValue($value): string
    {
        $text = trim((string) $value);

        return $text !== '' ? $text : '—';
    }
}

if (! function_exists('idCardStudentClassLabel')) {
    function idCardStudentClassLabel($sessionStudent, $idCard = null): string
    {
        $parts = [];
        if (! $idCard || $idCard->class_name) {
            $parts[] = $sessionStudent->class->name ?? '';
        }
        if (! $idCard || $idCard->section_name) {
            $parts[] = $sessionStudent->section->name ?? '';
        }

        return trim(implode(' / ', array_filter($parts)));
    }
}

if (! function_exists('idCardStudentContext')) {
    /** @return array<string, mixed> */
    function idCardStudentContext($sessionStudent, $idCard, bool $preview = false): array
    {
        $sessionName = \App\Models\Session::find(setting('session'))?->name ?? (string) setting('session');
        $issueDate = now()->format('d/m/Y');
        $expiry = $idCard && $idCard->expired_date ? date('d/m/Y', strtotime($idCard->expired_date)) : '';

        if ($preview || ! $sessionStudent) {
            return [
                'photo_url' => null,
                'student_name' => 'Student Name',
                'admission_no' => '122302',
                'class_course' => 'DIT / Semester 1 (6 Months)',
                'session_year' => $sessionName ?: '2026',
                'issue_date' => $issueDate,
                'expiry_date' => $expiry ?: '31/12/2026',
                'qr_url' => $idCard?->qrCode ? globalAsset($idCard->qrCode->path, '200X200.webp') : null,
            ];
        }

        $sessionStudent->loadMissing(['student.upload', 'student.blood', 'class', 'section']);
        $student = $sessionStudent->student;

        return [
            'photo_url' => $student?->upload ? globalAsset($student->upload->path, '200X200.webp') : null,
            'student_name' => trim(($student->first_name ?? '').' '.($student->last_name ?? '')),
            'admission_no' => (string) ($student->admission_no ?? ''),
            'class_course' => idCardStudentClassLabel($sessionStudent, $idCard),
            'session_year' => (string) $sessionName,
            'issue_date' => $issueDate,
            'expiry_date' => $expiry,
            'roll_no' => (string) ($student->roll_no ?? ''),
            'dob' => $student?->dob ? date('d/m/Y', strtotime($student->dob)) : '',
            'blood_group' => $student?->blood?->name ?? '',
            'qr_url' => $idCard?->qrCode ? globalAsset($idCard->qrCode->path, '200X200.webp') : null,
        ];
    }
}

if (! function_exists('idCardTeacherContext')) {
    /** @return array<string, mixed> */
    function idCardTeacherContext($staff, $idCard, bool $preview = false): array
    {
        if ($preview || ! $staff) {
            return [
                'photo_url' => null,
                'teacher_name' => 'Teacher Name',
                'employee_id' => 'EMP-001',
                'designation' => 'Instructor',
                'department' => 'Academic',
                'joining_date' => '01/01/2026',
                'contact' => '+92 300 0000000',
                'qr_url' => $idCard?->qrCode ? globalAsset($idCard->qrCode->path, '200X200.webp') : null,
            ];
        }

        $staff->loadMissing(['upload', 'designation', 'department']);

        return [
            'photo_url' => $staff->upload ? globalAsset($staff->upload->path, '200X200.webp') : null,
            'teacher_name' => trim(($staff->first_name ?? '').' '.($staff->last_name ?? '')),
            'employee_id' => (string) ($staff->staff_id ?? $staff->id),
            'designation' => $staff->designation->name ?? '',
            'department' => $staff->department->name ?? '',
            'joining_date' => $staff->joining_date ? date('d/m/Y', strtotime($staff->joining_date)) : '',
            'contact' => (string) ($staff->phone ?? ''),
            'qr_url' => $idCard?->qrCode ? globalAsset($idCard->qrCode->path, '200X200.webp') : null,
        ];
    }
}
