<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('generate:report', function () {
    \Botble\Admanager\Services\Admanager::main('today','TODAY','today');
    \Botble\Admanager\Services\Admanager::main('yesterday','YESTERDAY','yesterday');
//    \Botble\Admanager\Services\Admanager::main('last_6_months','LAST_6_MONTHS','last_6_months');
//    \Botble\Admanager\Services\Admanager::main('yesterday','YESTERDAY','yesterday');
//    \Botble\Admanager\Services\Admanager::main('last_week','LAST_WEEK','last_week');
//    \Botble\Admanager\Services\Admanager::main('last_month','LAST_MONTH','last_month');
//    \Botble\Admanager\Services\Admanager::main('last_3_months','LAST_3_MONTHS','last_3_months');
//    \Botble\Admanager\Services\Admanager::main('reach_lifetime','REACH_LIFETIME','reach_lifetime');
    $this->info('Generated report successfully!');
});
