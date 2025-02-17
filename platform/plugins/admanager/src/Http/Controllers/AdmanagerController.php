<?php

namespace Botble\Admanager\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Admanager\Http\Requests\AdmanagerRequest;
use Botble\Admanager\Models\Admanager;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Admanager\Tables\AdmanagerTable;
use Botble\Admanager\Forms\AdmanagerForm;
use Botble\Setting\Facades\Setting;
use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Adsense;
use Illuminate\Support\Facades\Session;

class AdmanagerController extends BaseController
{
    public function __construct()
    {
        $this
            ->breadcrumb()
            ->add(trans(trans('plugins/admanager::admanager.name')), route('admanager.index'));
    }

    public function index(AdmanagerTable $table)
    {
        $this->pageTitle(trans('plugins/admanager::admanager.name'));

        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/admanager::admanager.create'));

        return AdmanagerForm::create()->renderForm();
    }

    public function store(AdmanagerRequest $request)
    {
        $form = AdmanagerForm::create()->setRequest($request);

        $form->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('admanager.index'))
            ->setNextUrl(route('admanager.edit', $form->getModel()->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(Admanager $admanager)
    {
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $admanager->name]));

        return AdmanagerForm::createFromModel($admanager)->renderForm();
    }

    public function update(Admanager $admanager, AdmanagerRequest $request)
    {
        AdmanagerForm::createFromModel($admanager)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('admanager.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Admanager $admanager)
    {
        return DeleteResourceAction::make($admanager);
    }

    public function googleAuth()
    {
        if(!setting('adsense_json')) return;

        $client = new Google_Client();

        $client->setAuthConfig(storage_path('client_secret_784811326981-gi2kfp720va064drp7brfva4o59vkfj4.apps.googleusercontent.com.json'));

        $client->addScope(Google_Service_Adsense::ADSENSE_READONLY);

        $redirectUri = 'http://127.0.0.1:8000/admin/admanagers/google/callback';
        $client->setRedirectUri($redirectUri);

        $client->setAccessType('offline');
        $client->setPrompt('consent');

        $authUrl = $client->createAuthUrl();

        return redirect()->away($authUrl);
    }
    public function googleCallback(Request $request)
    {
        if(!setting('adsense_json')) return;

        $client = new Google_Client();
        $client->setAuthConfig(storage_path('client_secret_784811326981-gi2kfp720va064drp7brfva4o59vkfj4.apps.googleusercontent.com.json'));
        $client->setRedirectUri('http://127.0.0.1:8000/admin/admanagers/google/callback');
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        $client->addScope(Google_Service_Adsense::ADSENSE_READONLY);

        if (!$request->has('code')) {
            return redirect()->route('admanager.google.auth')->with('error', 'No se recibió el código de autorización.');
        }

        $token = $client->fetchAccessTokenWithAuthCode($request->code);

        Session::put('google_access_token', $token);
        Session::save();

        if(setting('google_access_token.access_token'))
        {
            Setting::set('google_access_token', $token);
            Setting::save();
        }

        return redirect()->route('admanager.edit');
    }
    public function getAdsenseData()
    {
        if(!setting('adsense_json')) return;

        $client = new Google_Client();
        $client->setAuthConfig(storage_path('client_secret_784811326981-gi2kfp720va064drp7brfva4o59vkfj4.apps.googleusercontent.com.json'));
        $client->setAccessType('offline');
        $client->addScope(Google_Service_Adsense::ADSENSE_READONLY);

        // Cargar el token de acceso de la sesión
        if (!Session::has('google_access_token')) {
            return redirect()->route('google.auth')->with('error', 'Es necesario autenticarse nuevamente.');
        }

        $client->setAccessToken(Session::get('google_access_token'));

        // Verificar si el token ha expirado y refrescarlo si es necesario
        if ($client->isAccessTokenExpired()) {
            $refreshToken = Session::get('google_access_token')['refresh_token'] ?? null;

            if ($refreshToken) {
                $newToken = $client->fetchAccessTokenWithRefreshToken($refreshToken);
                Session::put('google_access_token', $newToken);
                Session::save();
            } else {
                return redirect()->route('admanager.google.auth')->with('error', 'Token expirado, por favor autentícate de nuevo.');
            }
        }

        // Inicializar el servicio de AdSense
        $adsenseService = new Google_Service_Adsense($client);

        // ID de la cuenta de AdSense
        $accountId = 'pub-9190095624585011';

        try {
            $sites = $adsenseService->accounts_sites->listAccountsSites("accounts/$accountId");
            return response()->json($sites);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
