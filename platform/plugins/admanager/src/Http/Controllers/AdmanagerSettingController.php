<?php
namespace Botble\Admanager\Http\Controllers;

use Botble\Admanager\Forms\AdmanagerSettingForm;
use Botble\Admanager\Http\Requests\AdmanagerRequest;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Media\RvMedia;
use Botble\Setting\Facades\Setting;
use Botble\Setting\Http\Controllers\SettingController;

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
            $nuevaRuta = 'jsonKeyFilePath = "' . storage_path(setting('admanager_json'))  .'"';
            $contenidoModificado = preg_replace(
                '/jsonKeyFilePath\s*=\s*".*?"/',
                $nuevaRuta,
                $contenido
            );

            file_put_contents($adsapi, $contenidoModificado);
        }
        if(setting('admanager_network_code') != $request->input('admanager_network_code'))
        {
            $adsapi = storage_path('adsapi_php.ini');
            $contenido = file_get_contents($adsapi);
            $nuevaRuta = 'networkCode = "' . $request->input('admanager_network_code')  .'"';
            $contenidoModificado = preg_replace(
                '/networkCode\s*=\s*".*?"/',
                $nuevaRuta,
                $contenido
            );

            file_put_contents($adsapi, $contenidoModificado);

            Setting::set('admanager_network_code', $request->input('admanager_network_code'));
        }
        if(setting('admanager_network_name') != $request->input('admanager_network_name'))
        {
            $adsapi = storage_path('adsapi_php.ini');
            $contenido = file_get_contents($adsapi);
            $nuevaRuta = 'applicationName = "' . $request->input('admanager_network_name')  .'"';
            $contenidoModificado = preg_replace(
                '/applicationName\s*=\s*".*?"/',
                $nuevaRuta,
                $contenido
            );

            file_put_contents($adsapi, $contenidoModificado);

            Setting::set('admanager_network_name', $request->input('admanager_network_name'));
        }

        Setting::set('admanager_json', $request->input('admanager_json'));
        Setting::set('percentage_default', $request->input('percentage_default'));
        Setting::set('week_start', $request->input('week_start'));

        return $this->performUpdate($request->validated());
    }
}
