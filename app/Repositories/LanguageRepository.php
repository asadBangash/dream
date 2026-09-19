<?php

namespace App\Repositories;

use App\Interfaces\LanguageInterface;
use App\Models\Language;
use App\Models\SectionTranslate;
use App\Models\SettingTranslate;
use App\Models\WebsiteSetup\PageSections;
use Illuminate\Support\Facades\File;

class LanguageRepository implements LanguageInterface
{

    private $model;

    public function __construct(Language $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return Language::all();
    }

    public function getAll()
    {
        return Language::latest()->paginate(5);
    }

    public function store($request)
    {
        try {
            $languageStore             = new $this->model;
            $languageStore->name       = $request->name;
            $languageStore->code       = $request->code;
            $languageStore->icon_class = $request->flagIcon;
            $languageStore->direction  = $request->direction;
            $languageStore->save();

            $path = base_path('lang/' . $request->code);
            if (!File::isDirectory($path)):
                File::makeDirectory($path, 0777, true, true);
                File::copyDirectory(base_path('lang/en'), base_path('lang/' . $request->code));

            endif;

            $social_links           = PageSections::where('key', 'social_links')->first();
            $social_links_translate = SectionTranslate::where(['section_id' => $social_links->id, 'locale' => $request->code])->first();
            if (!$social_links_translate) {
                $social_link_en   = SectionTranslate::where(['section_id' => $social_links->id, 'locale' => 'en'])->first();
                $row              = new SectionTranslate();
                $row->section_id  = $social_link_en->section_id;
                $row->locale      = $request->code;
                $row->name        = $social_link_en->name;
                $row->description = $social_link_en->description;
                $row->data        = $social_link_en->data;
                $row->save();
            }

            $why_choose_us           = PageSections::where('key', 'why_choose_us')->first();
            $why_choose_us_translate = SectionTranslate::where(['section_id' => $why_choose_us->id, 'locale' => $request->code])->first();
            if (!$why_choose_us_translate) {
                $why_choose_us_en = SectionTranslate::where(['section_id' => $why_choose_us->id, 'locale' => 'en'])->first();
                $row              = new SectionTranslate();
                $row->section_id  = $why_choose_us_en->section_id;
                $row->locale      = $request->code;
                $row->name        = $why_choose_us_en->name;
                $row->description = $why_choose_us_en->description;
                $row->data        = $why_choose_us_en->data;
                $row->save();
            }

            $academic_curriculum           = PageSections::where('key', 'academic_curriculum')->first();
            $academic_curriculum_translate = SectionTranslate::where(['section_id' => $academic_curriculum->id, 'locale' => $request->code])->first();
            if (!$academic_curriculum_translate) {
                $academic_curriculum_en = SectionTranslate::where(['section_id' => $academic_curriculum->id, 'locale' => 'en'])->first();
                $row                    = new SectionTranslate();
                $row->section_id        = $academic_curriculum_en->section_id;
                $row->locale            = $request->code;
                $row->name              = $academic_curriculum_en->name;
                $row->description       = $academic_curriculum_en->description;
                $row->data              = $academic_curriculum_en->data;
                $row->save();
            }

            // general setting options

            $row = SettingTranslate::where(['name' => 'application_name', 'locale' => $request->code])->first();
            if (!$row) {
                $en_row          = SettingTranslate::where(['name' => 'application_name', 'locale' => 'en'])->first();
                $row             = new SettingTranslate();
                $row->setting_id = $en_row->setting_id;
                $row->value      = $en_row->value;
                $row->from       = 'general_settings';
                $row->locale     = $request->code;
                $row->name       = $en_row->name;
                $row->save();
            }

            $row = SettingTranslate::where(['name' => 'footer_text', 'locale' => $request->code])->first();
            if (!$row) {
                $en_row          = SettingTranslate::where(['name' => 'footer_text', 'locale' => 'en'])->first();
                $row             = new SettingTranslate();
                $row->setting_id = $en_row->setting_id;
                $row->value      = $en_row->value;
                $row->from       = 'general_settings';
                $row->locale     = $request->code;
                $row->name       = $en_row->name;
                $row->save();
            }

            $row = SettingTranslate::where(['name' => 'address', 'locale' => $request->code])->first();
            if (!$row) {
                $en_row          = SettingTranslate::where(['name' => 'address', 'locale' => 'en'])->first();
                $row             = new SettingTranslate();
                $row->setting_id = $en_row->setting_id;
                $row->value      = $en_row->value;
                $row->from       = 'general_settings';
                $row->locale     = $request->code;
                $row->name       = $en_row->name;
                $row->save();
            }

            $row = SettingTranslate::where(['name' => 'phone', 'locale' => $request->code])->first();
            if (!$row) {
                $en_row          = SettingTranslate::where(['name' => 'phone', 'locale' => 'en'])->first();
                $row             = new SettingTranslate();
                $row->setting_id = $en_row->setting_id;
                $row->value      = $en_row->value;
                $row->from       = 'general_settings';
                $row->locale     = $request->code;
                $row->name       = $en_row->name;
                $row->save();
            }

            $row = SettingTranslate::where(['name' => 'school_about', 'locale' => $request->code])->first();
            if (!$row) {
                $en_row          = SettingTranslate::where(['name' => 'school_about', 'locale' => 'en'])->first();
                $row             = new SettingTranslate();
                $row->setting_id = $en_row->setting_id;
                $row->value      = $en_row->value;
                $row->from       = 'general_settings';
                $row->locale     = $request->code;
                $row->name       = $en_row->name;
                $row->save();
            }

            return true;
        } catch (\Throwable $th) {

            return false;
        }
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function update($request, $id)
    {
        try {
            $language             = $this->model->findOrfail($id);
            $language->name       = $request->name;
            $language->code       = $request->code;
            $language->icon_class = $request->flagIcon;
            $language->direction  = $request->direction;

            $language->save();
            $social_links           = PageSections::where('key', 'social_links')->first();
            $social_links_translate = SectionTranslate::where(['section_id' => $social_links->id, 'locale' => $request->code])->first();
            if (!$social_links_translate) {
                $social_link_en   = SectionTranslate::where(['section_id' => $social_links->id, 'locale' => 'en'])->first();
                $row              = new SectionTranslate();
                $row->section_id  = $social_link_en->section_id;
                $row->locale      = $request->code;
                $row->name        = $social_link_en->name;
                $row->description = $social_link_en->description;
                $row->data        = $social_link_en->data;
                $row->save();
            }

            $why_choose_us           = PageSections::where('key', 'why_choose_us')->first();
            $why_choose_us_translate = SectionTranslate::where(['section_id' => $why_choose_us->id, 'locale' => $request->code])->first();
            if (!$why_choose_us_translate) {
                $why_choose_us_en = SectionTranslate::where(['section_id' => $why_choose_us->id, 'locale' => 'en'])->first();
                $row              = new SectionTranslate();
                $row->section_id  = $why_choose_us_en->section_id;
                $row->locale      = $request->code;
                $row->name        = $why_choose_us_en->name;
                $row->description = $why_choose_us_en->description;
                $row->data        = $why_choose_us_en->data;
                $row->save();
            }

            $academic_curriculum           = PageSections::where('key', 'academic_curriculum')->first();
            $academic_curriculum_translate = SectionTranslate::where(['section_id' => $academic_curriculum->id, 'locale' => $request->code])->first();
            if (!$academic_curriculum_translate) {
                $academic_curriculum_en = SectionTranslate::where(['section_id' => $academic_curriculum->id, 'locale' => 'en'])->first();
                $row                    = new SectionTranslate();
                $row->section_id        = $academic_curriculum_en->section_id;
                $row->locale            = $request->code;
                $row->name              = $academic_curriculum_en->name;
                $row->description       = $academic_curriculum_en->description;
                $row->data              = $academic_curriculum_en->data;
                $row->save();
            }

            // general setting options

            $row = SettingTranslate::where(['name' => 'application_name', 'locale' => $request->code])->first();
            if (!$row) {
                $en_row          = SettingTranslate::where(['name' => 'application_name', 'locale' => 'en'])->first();
                $row             = new SettingTranslate();
                $row->setting_id = $en_row->setting_id;
                $row->value      = $en_row->value;
                $row->from       = 'general_settings';
                $row->locale     = $request->code;
                $row->name       = $en_row->name;
                $row->save();
            }

            $row = SettingTranslate::where(['name' => 'footer_text', 'locale' => $request->code])->first();
            if (!$row) {
                $en_row          = SettingTranslate::where(['name' => 'footer_text', 'locale' => 'en'])->first();
                $row             = new SettingTranslate();
                $row->setting_id = $en_row->setting_id;
                $row->value      = $en_row->value;
                $row->from       = 'general_settings';
                $row->locale     = $request->code;
                $row->name       = $en_row->name;
                $row->save();
            }

            $row = SettingTranslate::where(['name' => 'address', 'locale' => $request->code])->first();
            if (!$row) {
                $en_row          = SettingTranslate::where(['name' => 'address', 'locale' => 'en'])->first();
                $row             = new SettingTranslate();
                $row->setting_id = $en_row->setting_id;
                $row->value      = $en_row->value;
                $row->from       = 'general_settings';
                $row->locale     = $request->code;
                $row->name       = $en_row->name;
                $row->save();
            }

            $row = SettingTranslate::where(['name' => 'phone', 'locale' => $request->code])->first();
            if (!$row) {
                $en_row          = SettingTranslate::where(['name' => 'phone', 'locale' => 'en'])->first();
                $row             = new SettingTranslate();
                $row->setting_id = $en_row->setting_id;
                $row->value      = $en_row->value;
                $row->from       = 'general_settings';
                $row->locale     = $request->code;
                $row->name       = $en_row->name;
                $row->save();
            }

            $row = SettingTranslate::where(['name' => 'school_about', 'locale' => $request->code])->first();
            if (!$row) {
                $en_row          = SettingTranslate::where(['name' => 'school_about', 'locale' => 'en'])->first();
                $row             = new SettingTranslate();
                $row->setting_id = $en_row->setting_id;
                $row->value      = $en_row->value;
                $row->from       = 'general_settings';
                $row->locale     = $request->code;
                $row->name       = $en_row->name;
                $row->save();
            }

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function destroy($id)
    {
        try {
            $languageDestroy = $this->model->find($id);
            // delete directory
            File::deleteDirectory(base_path('lang/' . $languageDestroy->code));
            $languageDestroy->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function terms($id)
    {
        $data['title']    = 'Langauge Terms';
        $data['language'] = $this->show($id);
        $path             = base_path('lang/' . $data['language']->code);

        if (!File::isDirectory($path)):
            File::makeDirectory($path, 0777, true, true);
            File::copyDirectory(base_path('lang/en'), base_path('lang/' . $data['language']->code));

        endif;

        $data['terms'] = [];
        return $data;
    }

    public function termsUpdate($request, $code)
    {
        try {
            $path = base_path('lang/' . $code);

            // Get existing translations if file exists
            if (file_exists($path . "/$request->lang_module.json")) {
                $jsonString = file_get_contents($path . "/$request->lang_module.json");
                $data       = json_decode($jsonString, true) ?: [];
            } else {
                // If file doesn't exist, get English translations as base
                $enPath     = base_path("lang/en/$request->lang_module.json");
                $jsonString = file_exists($enPath) ? file_get_contents($enPath) : '{}';
                $data       = json_decode($jsonString, true) ?: [];
            }

            // Get all translation keys from the request
            $requestKeys = collect($request->terms)->keys();

            // Update existing and add new translations
            foreach ($requestKeys as $key) {
                if ($request->terms[$key]) {
                    $data[$key] = $request->terms[$key];
                }
            }

            $newJsonString = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

            file_put_contents(base_path("lang/$code/$request->lang_module.json"), stripslashes($newJsonString));

            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
