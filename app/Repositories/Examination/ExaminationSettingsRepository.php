<?php

namespace App\Repositories\Examination;

use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use App\Models\Examination\ExaminationSettings;
use App\Interfaces\Examination\ExaminationSettingsInterface;

class ExaminationSettingsRepository implements ExaminationSettingsInterface
{
    use ReturnFormatTrait;

    private $model;

    public function __construct(ExaminationSettings $model)
    {
        $this->model = $model;
    }

    public function updateSetting($request)
    {
        try {
            foreach($request->fields as $key=>$field) {

                $setting            = $this->model::where('name', $field)->where('session_id', setting('session'))->first();
                if($setting){
                    $setting->value = $request->values[$key];
                }else{
                    $setting              = new $this->model;
                    $setting->name        = $field;
                    $setting->session_id  = setting('session');
                    $setting->value       = $request->values[$key];
                }
                $setting->save();

            }
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

}
