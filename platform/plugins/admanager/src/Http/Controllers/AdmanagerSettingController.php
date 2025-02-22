<?php
namespace Botble\Admanager\Http\Controllers;

use Botble\Admanager\Forms\AdmanagerSettingForm;
use Botble\Admanager\Http\Requests\AdmanagerRequest;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Media\RvMedia;
use Botble\Setting\Facades\Setting;
use Botble\Setting\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Storage;

class AdmanagerSettingController extends SettingController
{
    public function edit()
    {
        $this->pageTitle(trans('Google Ad Manager'));

        return AdmanagerSettingForm::create()->renderForm();
    }

    public function update(AdmanagerRequest $request)
    {
        return $this->performUpdate($request->validated());
    }
}
