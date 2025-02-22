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
        if(setting('admanager_json') != $request->input('admanager_json'))
        {
            $adsapi = storage_path('adsapi_php.ini');
            $contenido = file_get_contents($adsapi);
            $nuevaRuta = 'jsonKeyFilePath = "' . Storage::url(setting('admanager_json'))  .'"';
            $contenidoModificado = preg_replace(
                '/jsonKeyFilePath\s*=\s*".*?"/',
                $nuevaRuta,
                $contenido
            );

            file_put_contents($adsapi, $contenidoModificado);
        }

        return $this->performUpdate($request->validated());
    }
}
