<?php

use Botble\Base\Facades\AdminHelper;
use Botble\Domain\Http\Controllers\DomainController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

AdminHelper::registerRoutes(function () {
    Route::group(['prefix' => 'domains', 'as' => 'domain.'], function () {
        Route::resource('', DomainController::class)->parameters(['' => 'domain']);
    });
});
