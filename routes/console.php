<?php

use App\Jobs\CheckStuckMatchesJob;
use App\Jobs\ExpireStuckMatchesJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Jobs\UpdateListingPricesJob;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule::job(new UpdateListingPricesJob)
//     ->daily()
//     ->name('listing-auto-step');

// Schedule::job(new UpdateListingPricesJob)
//     ->everyFiveMinutes()
//     ->name('listing-auto-step');
Schedule::job(new UpdateListingPricesJob)
    ->everyFiveMinutes()
    ->name('update-listing-prices');
Schedule::job(new CheckStuckMatchesJob)
    ->hourly()
    ->name('check-stuck-matches');

Schedule::job(new ExpireStuckMatchesJob)
    ->daily()          // можно hourly()
    ->name('expire-stuck-matches');

Schedule::call(function () {
    Log::info('🔥 SCHEDULE TEST FIRED');
})->everyMinute();
