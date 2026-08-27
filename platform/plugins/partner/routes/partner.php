<?php

use Botble\Partner\Http\Controllers\PartnerDashboardController;
use Botble\Theme\Facades\Theme;
use Illuminate\Support\Facades\Route;

if (defined('THEME_MODULE_SCREEN_NAME')) {
    Theme::registerRoutes(function (): void {
        Route::group([
            'prefix' => 'partner',
            'as' => 'partner.',
            'middleware' => ['web', 'core', 'member', 'member.kyc.not', 'partner'],
        ], function (): void {
            Route::get('dashboard', [PartnerDashboardController::class, 'index'])->name('dashboard');
            Route::get('accounts', [PartnerDashboardController::class, 'accounts'])->name('accounts');
            Route::get('domains', [PartnerDashboardController::class, 'domains'])->name('domains');
        });
    });
}
