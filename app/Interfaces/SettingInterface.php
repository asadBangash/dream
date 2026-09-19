<?php

namespace App\Interfaces;

use App\Http\Requests\SettingStoreRequest;

interface SettingInterface{

    public function getAll();

    public function getLanguage();

    public function getSessions();

    public function getCurrencies();

    public function updateRecaptchaSetting(SettingStoreRequest $request);

    public function updateSmsSetting($request);

    public function updatePaymentGatewaySetting($request);

    public function storageSettingUpdate($request);

    public function updateMailSetting($request);

    public function updateGeneralSetting($request);

    public function updateTaxSetting($request);
}
