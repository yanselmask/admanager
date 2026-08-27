<?php

namespace Botble\Partner\Http\Controllers;

use Botble\Partner\Forms\PartnerSettingForm;
use Botble\Partner\Http\Requests\PartnerSettingRequest;
use Botble\Setting\Http\Controllers\SettingController;

class PartnerSettingController extends SettingController
{
    public function edit()
    {
        $this->pageTitle(trans('plugins/partner::partner.settings.title'));

        return PartnerSettingForm::create()->renderForm();
    }

    public function update(PartnerSettingRequest $request)
    {
        return $this->performUpdate($request->validated());
    }
}
