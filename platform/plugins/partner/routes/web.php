<?php

use Botble\Base\Facades\AdminHelper;
use Botble\Partner\Http\Controllers\PartnerController;
use Botble\Partner\Http\Controllers\PartnerNetworkController;
use Botble\Partner\Http\Controllers\PartnerSettingController;
use Illuminate\Support\Facades\Route;

AdminHelper::registerRoutes(function (): void {
    Route::group(['prefix' => 'partners', 'as' => 'partner.'], function (): void {
        Route::resource('', PartnerController::class)->parameters(['' => 'partner']);
    });

    Route::group(['prefix' => 'partner-networks', 'as' => 'partner-network.'], function (): void {
        Route::resource('', PartnerNetworkController::class)->parameters(['' => 'partner_network']);
    });

    Route::group(['prefix' => 'settings', 'as' => 'partner.'], function (): void {
        Route::get('partners', [
            'as' => 'settings',
            'uses' => [PartnerSettingController::class, 'edit'],
        ]);

        Route::put('partners', [
            'as' => 'settings.update',
            'uses' => [PartnerSettingController::class, 'update'],
            'permission' => 'partner.settings',
        ]);
    });
});
