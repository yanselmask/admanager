<?php

use Botble\Base\Facades\AdminHelper;
use Illuminate\Support\Facades\Route;
use Botble\Admanager\Http\Controllers\AdmanagerController;


Route::group(['namespace' => 'Botble\Admanager\Http\Controllers'], function(){
    AdminHelper::registerRoutes(function () {
        Route::group(['prefix' => 'admanagers', 'as' => 'admanager.'], function () {
            Route::resource('', 'AdmanagerController')->parameters(['' => 'admanager']);
            Route::get('/google/auth', [AdmanagerController::class, 'googleAuth'])->name('google.auth');
            Route::get('/google/callback', [AdmanagerController::class, 'googleCallback'])->name('google.callback');

            Route::get('adsense', [
                'as' => 'settings',
                'uses' => 'AdmanagerSettingController@edit',
            ]);

            Route::put('adsense', [
                'as' => 'settings.update',
                'uses' => 'AdmanagerSettingController@update',
                'permission' => 'admanager.settings',
            ]);
        });
    });
});
