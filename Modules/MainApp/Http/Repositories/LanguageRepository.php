<?php

namespace Modules\MainApp\Http\Repositories;

use Illuminate\Support\Facades\File;
use Modules\MainApp\Entities\Language;
use Modules\MainApp\Http\Interfaces\LanguageInterface;

class LanguageRepository implements LanguageInterface{

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
        return Language::latest()->paginate(10);
    }

    public function store($request)
    {
        try {
            $languageStore               = new $this->model;
            $languageStore->name         = $request->name;
            $languageStore->code         = $request->code;
            $languageStore->icon_class   = $request->flagIcon;
            $languageStore->direction    = $request->direction;
            $languageStore->save();

            $path                = base_path('lang/' . $request->code);
            if (!File::isDirectory($path)) :
                File::makeDirectory($path, 0777, true, true);
                File::copyDirectory(base_path('lang/en'), base_path('lang/' . $request->code));

            endif;


            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function update($request,$id)
    {
        try {
            $language               = $this->model->findOrfail($id);
            $language->name         = $request->name;
            $language->code         = $request->code;
            $language->icon_class   = $request->flagIcon;
            $language->direction    = $request->direction;

            $language->save();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function destroy($id)
    {
        try {
            $languageDestroy   = $this->model->find($id);
            // delete directory
            File::deleteDirectory(base_path('lang/'.$languageDestroy->code));
            $languageDestroy->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function terms($id)
    {
        $data['title']       = 'Langauge Terms';
        $data['language']    = $this->show($id);
        $path                = base_path('lang/' . $data['language']->code);

        if (!File::isDirectory($path)) :
            File::makeDirectory($path, 0777, true, true);
            File::copyDirectory(base_path('lang/en'), base_path('lang/' . $data['language']->code));

        endif;

        if (File::isDirectory($path)) {
            $jsonString          = file_get_contents(base_path("lang/".$data['language']->code."/common.json"));
        }else{
            $jsonString          = file_get_contents(base_path('lang/en/common.json'));
        }
        $data['terms']           = json_decode($jsonString, true);
        return $data;
    }

    public function termsUpdate($request, $code)
    {
        try {
            $module = basename($request->lang_module);
            $sourceFile = base_path("lang/en/{$module}");
            $targetFile = base_path("lang/{$code}/{$module}");

            if (!File::exists($sourceFile)) {
                return false;
            }

            $jsonString = file_get_contents($targetFile);
            $data = json_decode($jsonString, true);
            foreach ($data as $key => $value) {
                if ($request->has($key)) {
                    $data[$key] = $request->$key;
                }
                else {
                    $underscoreKey = str_replace(' ', '_', $key);
                    if ($request->has($underscoreKey)) {
                        $data[$key] = $request->$underscoreKey;
                    }
                }
            }

            $newJsonString = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            file_put_contents($targetFile, $newJsonString);

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
