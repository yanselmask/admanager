<?php

use Botble\Admanager\Services\Admanager;
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
    $manageNetworks = new \Botble\Admanager\Services\Admanager();
    foreach ($manageNetworks->getNetworksCodeAndName() as $key => $value)
    {
        foreach (json_decode(setting('earning_member')) as $date)
        {
                $manager = new Admanager();
                $manager->setNetworkCode($key)
                        ->setNetworkName($value)
                        ->setDateCsv($date)
                        ->setDateRangeType(strtoupper($date))
                        ->setColumn($date)
                        ->run();
        }

    }
    $this->info('Generated report successfully!');
});

Artisan::command('generate:report:custom {date}', function () {
    $manageNetworks = new \Botble\Admanager\Services\Admanager();
    foreach ($manageNetworks->getNetworksCodeAndName() as $key => $value)
    {
        $date = $this->argument('date');

        $manager = new Admanager();
        $manager->setNetworkCode($key)
            ->setNetworkName($value)
            ->setDateCsv(strtolower($date))
            ->setDateRangeType(strtoupper($date))
            ->setColumn(strtolower($date))
            ->run();
    }
});
