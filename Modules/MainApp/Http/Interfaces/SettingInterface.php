<?php

namespace Modules\MainApp\Http\Interfaces;

interface SettingInterface{

    public function getAll();

    public function getLanguage();

    public function getCurrencies();

    public function updateGeneralSetting($request);
}
