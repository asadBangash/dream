<?php

namespace Modules\MainApp\Database\Seeders;

use App\Models\Setting;
use App\Traits\CommonHelperTrait;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

class SettingSeeder extends Seeder
{
    use CommonHelperTrait;

    public function run()
    {
        $schoolName = env('APP_NAME', 'School');
        $domain = env('APP_DOMAIN', 'school.com');
        Setting::create([
            'name'  => 'application_name',
            'value' => $schoolName . ' Management System',
        ]);
        Setting::create([
            'name'  => 'address',
            'value' => 'University Road, Peshawar, Khyber Pakhtunkhwa, Pakistan',
        ]);
        Setting::create([
            'name'  => 'phone',
            'value' => '+92 91 1234567',
        ]);
        Setting::create([
            'name'  => 'email',
            'value' => 'info@' . $domain,
        ]);
        Setting::create([
            'name'  => 'school_about',
            'value' => 'The Dream Tuition Academy is a leading tuition centre in Peshawar, Pakistan, dedicated to quality education, disciplined learning, and strong academic results.',
        ]);

        Setting::create([
            'name'  => 'footer_text',
            'value' => '© ' . Carbon::now()->year . ' ' . $schoolName . '. All rights reserved.',
        ]);

        Setting::create([
            'name'  => 'file_system',
            'value' => 'local',
        ]);
        Setting::create([
            'name'  => 'aws_access_key_id',
            'value' => env('AWS_ACCESS_KEY_ID', ''),
        ]);
        Setting::create([
            'name'  => 'aws_secret_key',
            'value' => env('AWS_SECRET_ACCESS_KEY', ''),
        ]);
        Setting::create([
            'name'  => 'aws_region',
            'value' => 'ap-southeast-1',
        ]);
        Setting::create([
            'name'  => 'aws_bucket',
            'value' => $schoolName,
        ]);
        Setting::create([
            'name'  => 'aws_endpoint',
            'value' => 'https://s3.ap-southeast-1.amazonaws.com',
        ]);
        Setting::create([
            'name'  => 'recaptcha_sitekey',
            'value' => env('NOCAPTCHA_SITEKEY', ''),
        ]);
        Setting::create([
            'name'  => 'recaptcha_secret',
            'value' => env('NOCAPTCHA_SECRET', ''),
        ]);
        Setting::create([
            'name'  => 'recaptcha_status',
            'value' => '0',
        ]);
        Setting::create([
            'name'  => 'mail_drive',
            'value' => 'smtp',
        ]);
        Setting::create([
            'name'  => 'mail_host',
            'value' => 'smtp.gmail.com',
        ]);
        Setting::create([
            'name'  => 'mail_address',
            'value' => 'info@' . $domain,
        ]);
        Setting::create([
            'name'  => 'from_name',
            'value' => $schoolName . ' - School Management System',
        ]);
        Setting::create([
            'name'  => 'mail_username',
            'value' => env('MAIL_USERNAME', 'info@' . $domain),
        ]);

        $mailPassword = env('MAIL_PASSWORD', '');
        Setting::create([
            'name'  => 'mail_password',
            'value' => $mailPassword !== '' ? Crypt::encrypt($mailPassword) : '',
        ]);

        Setting::create([
            'name'  => 'mail_port',
            'value' => '587',
        ]);
        Setting::create([
            'name'  => 'encryption',
            'value' => 'tls',
        ]);
        Setting::create([
            'name'  => 'default_langauge',
            'value' => 'en',
        ]);
        Setting::create([
            'name'  => 'light_logo',
            'value' => 'backend/uploads/settings/light.png',
        ]);
        Setting::create([
            'name'  => 'dark_logo',
            'value' => 'backend/uploads/settings/dark.png',
        ]);
        Setting::create([
            'name'  => 'favicon',
            'value' => 'backend/uploads/settings/favicon.png',
        ]);
        Setting::create([
            'name'  => 'session',
            'value' => 1,
        ]);
        Setting::create([
            'name'  => 'currency_code',
            'value' => 'USD',
        ]);
        Setting::create([
            'name'  => 'map_key',
            'value' => '"!1m18!1m12!1m3!1d3650.776241229233!2d90.40412657620105!3d23.790981078642808!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c72b14773d9d%3A0x21df6643cbfa879f!2sSookh!5e0!3m2!1sen!2sbd!4v1711600654298!5m2!1sen!2sbd"',
        ]);

    }
}
