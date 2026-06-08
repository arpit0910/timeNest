<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;
use App\Models\Auth\TempToken;

Schedule::call(function () {
    TempToken::where('expires_at', '<', now()->subDay())->delete();
})->daily()->name('cleanup:temp_tokens')->withoutOverlapping();
