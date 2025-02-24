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

    protected function clearIfNotExist($request, $key): void
    {
        if(!$request->$key)
        {
            setting()->set($key, null);
        }
    }

    public function update(AdmanagerRequest $request)
    {
        if(setting('admanager_json') != $request->input('admanager_json'))
        {
            $adsapi = storage_path('adsapi_php.ini');
            $contenido = file_get_contents($adsapi);
            $nuevaRuta = 'jsonKeyFilePath = "' . Storage::path(setting('admanager_json'))  .'"';
            $contenidoModificado = preg_replace(
                '/jsonKeyFilePath\s*=\s*".*?"/',
                $nuevaRuta,
                $contenido
            );

            file_put_contents($adsapi, $contenidoModificado);
        }

        $this->clearIfNotExist($request, 'admanager_networks');
        $this->clearIfNotExist($request, 'earning_member');
        $this->clearIfNotExist($request, 'impressions_member');
        $this->clearIfNotExist($request, 'clicks_member');
        $this->clearIfNotExist($request, 'ctrs_member');
        $this->clearIfNotExist($request, 'ecpms_member');
        $this->clearIfNotExist($request, 'kyc_fields');
        $this->clearIfNotExist($request, 'kyc_nationalities');
        $this->clearIfNotExist($request, 'kyc_documents_types');

        return $this->performUpdate($request->validated());
    }
}
