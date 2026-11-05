<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('security:check-anomalies')->everyFifteenMinutes();
Schedule::command('audit:verify')->dailyAt('02:00');
Schedule::command('security:weekly-summary')->weeklyOn(1, '07:00');
Schedule::call(fn () => app(\App\Services\AuditCheckpointService::class)->createCheckpoint())
    ->everyFifteenMinutes()
    ->name('audit:create-checkpoint');