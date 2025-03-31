<?php

use App\Console\Commands\PaymentUpdateBatch;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command(PaymentUpdateBatch::class, ['minutes' => 10])->hourly();

Schedule::command('purge:temp "App\Models\File" 1')->daily();
Schedule::command('purge:soft-deleted "App\Models\File" 30')->daily();

Schedule::command('disposable:update')->weekly();
