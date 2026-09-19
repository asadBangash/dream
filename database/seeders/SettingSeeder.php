<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use App\Models\SettingTranslate;
use App\Traits\CommonHelperTrait;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;


class SettingSeeder extends Seeder
{
    use CommonHelperTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $schoolName = env('APP_NAME', 'School');
        $domain     = env('APP_DOMAIN', 'school.com');

        $appname    = Setting::create([
            'name'  => 'application_name',
            'value' => Session::get('school_name') ??  $schoolName. ' Management System',
        ]);
        $address = Setting::create([
            'name'  => 'address',
            'value' =>  Session::get('address') ?? 'University Road, Peshawar, Khyber Pakhtunkhwa, Pakistan',
        ]);
        $phone = Setting::create([
            'name'  => 'phone',
            'value' => Session::get('admin_phone') ?? '+92 91 1234567',
        ]);
        Setting::create([
            'name'  => 'email',
            'value' => Session::get('admin_email') ?? 'info@' . $domain,
        ]);
        $school_about = Setting::create([
            'name'  => 'school_about',
            'value' => 'The Dream Tuition Academy is a leading tuition centre in Peshawar, Pakistan, dedicated to quality education, disciplined learning, and strong academic results. We support students across classes with expert faculty, structured courses, and a caring environment for parents and learners.',
        ]);
        $footer_text = Setting::create([
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

        // twillio sms

        Setting::create([
            'name'  => 'twilio_account_sid',
            'value' => env('TWILIO_ACCOUNT_SID', ''),
        ]);
        Setting::create([
            'name'  => 'twilio_auth_token',
            'value' => env('TWILIO_AUTH_TOKEN', ''),
        ]);
        Setting::create([
            'name'  => 'twilio_phone_number',
            'value' => env('TWILIO_PHONE_NUMBER', ''),
        ]);

        // recaptcha
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
            'value' => env('MAIL_USERNAME', ''),
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
            'value' => 'PKR',
        ]);
        Setting::create([
            'name'  => 'map_key',
            'value' => "!1m18!1m12!1m3!1d3650.776241229233!2d90.40412657620105!3d23.790981078642808!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c72b14773d9d%3A0x21df6643cbfa879f!2sSookh!5e0!3m2!1sen!2sbd!4v1711600654298!5m2!1sen!2sbd",
        ]);
        $phone = Setting::create([
            'name'  => 'country',
            'value' => 'Pakistan',
        ]);
        $phone = Setting::create([
            'name'  => 'timezone',
            'value' => 'Asia/Karachi',
        ]);

        Setting::create([
            'name'  => 'tax_percentage',
            'value' => 5,
        ]);

        Setting::create([
            'name' => 'tax_income_head',
            'value' => 'Income Tax',
        ]);

        Setting::create([
            'name' => 'tax_min_amount',
            'value' => '10000',
        ]);

        Setting::create([
            'name' => 'tax_max_amount',
            'value' => '1000000',
        ]);

        Setting::create([
            'name' => 'early_payment_discount_applicable',
            'value' => 0
        ]);

        Setting::create([
            'name' => 'siblings_discount_applicable',
            'value' => 0
        ]);


        // Setting::create([
        //     'name' => 'student_limit',
        //     'value' => Session::get('student_limit'),
        // ]);
        // Setting::create([
        //     'name' => 'staff_limit',
        //     'value' => Session::get('staff_limit'),
        // ]);
        // Setting::create([
        //     'name' => 'expiry_date',
        //     'value' => Session::get('expiry_date'),
        // ]);
        // Setting::create([
        //     'name' => 'features',
        //     'value' => Session::get('features'),
        // ]);

        if ($appname) {
            $row             = new SettingTranslate();
            $row->setting_id = $appname->id;
            $row->locale     = 'en';
            $row->name       = $appname->name;
            $row->value      = $appname->value;
            $row->save();

            $row             = new SettingTranslate();
            $row->setting_id = $appname->id;
            $row->locale     = 'bn';
            $row->name       = $appname->name;
            $row->value      = 'ওনেস্ট স্কুলড - স্কুল ম্যানেজমেন্ট সিস্টেম';
            $row->save();
        }
        if ($footer_text) {
            $row             = new SettingTranslate();
            $row->setting_id = $footer_text->id;
            $row->locale     = 'en';
            $row->name       = $footer_text->name;
            $row->value      = $footer_text->value;
            $row->save();

            $row             = new SettingTranslate();
            $row->setting_id = $footer_text->id;
            $row->locale     = 'bn';
            $row->name       = $footer_text->name;
            $row->value      = '© ' . Carbon::now()->year . ' ' . $schoolName;
            $row->save();

        }
        if ($address) {
            $row             = new SettingTranslate();
            $row->setting_id = $address->id;
            $row->locale     = 'en';
            $row->name       = $address->name;
            $row->value      = $address->value;
            $row->save();

            $row             = new SettingTranslate();
            $row->setting_id = $address->id;
            $row->locale     = 'bn';
            $row->name       = $address->name;
            $row->value      = 'রেসিমন্ট টাওয়ার, হাউজ 148, রোড 13/বি, ব্লক ই বনানী ঢাকা 1213।';
            $row->save();
        }
        if ($phone) {
            $row             = new SettingTranslate();
            $row->setting_id = $phone->id;
            $row->locale     = 'en';
            $row->name       = $phone->name;
            $row->value      = $phone->value;
            $row->save();

            $row             = new SettingTranslate();
            $row->setting_id = $phone->id;
            $row->locale     = 'bn';
            $row->name       = $phone->name;
            $row->value      = '+৬২ ৮৭৮৭ ৮৭৮৭';
            $row->save();
        }
        if ($school_about) {
            $row             = new SettingTranslate();
            $row->setting_id = $school_about->id;
            $row->locale     = 'en';
            $row->name       = $school_about->name;
            $row->value      = $school_about->value;
            $row->save();

            $row             = new SettingTranslate();
            $row->setting_id = $school_about->id;
            $row->locale     = 'bn';
            $row->name       = $school_about->name;
            $row->value      = setting('application_name') .  ' স্কুল ম্যানেজমেন্ট সফটওয়্যার (এসএমএস) হল একটি ডিজিটাল সমাধান যা শিক্ষা প্রতিষ্ঠানগুলিতে প্রশাসনিক, একাডেমিক এবং পরিচালনামূলক কাজগুলিকে সহজ এবং স্বয়ংক্রিয় করার জন্য ডিজাইন করা হয়েছে। এটি শিক্ষার্থীদের রেকর্ড, উপস্থিতি, ফি সংগ্রহ, কর্মী ব্যবস্থাপনা, একাডেমিক সময়সূচী এবং অভিভাবকদের সাথে যোগাযোগের মতো কার্যকলাপ পরিচালনা করার জন্য একটি কেন্দ্রীভূত প্ল্যাটফর্ম হিসেবে কাজ করে।';
            $row->save();
        }
    }
}
