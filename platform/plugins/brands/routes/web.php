<?php

use Botble\Base\Facades\AdminHelper;
use Botble\Brands\Http\Controllers\BrandsController;
use Illuminate\Support\Facades\Route;

AdminHelper::registerRoutes(function () {
    Route::group(['prefix' => 'brands', 'as' => 'brands.'], function () {
        Route::resource('', BrandsController::class)->parameters(['' => 'brands']);
    });
});
