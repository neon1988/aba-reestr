<?php

namespace App\Observers;

use App\Models\Center;
use Illuminate\Support\Facades\Cache;

class CenterObserver
{
    /**
     * Handle the Center "created" event.
     */
    public function created(Center $center): void
    {
        Cache::forget('stats.centersCount');
        Cache::forget('stats.centersOnReviewCount');
    }

    /**
     * Handle the Center "updated" event.
     */
    public function updated(Center $center): void
    {
        //
    }

    /**
     * Handle the Center "deleted" event.
     */
    public function deleted(Center $center): void
    {
        Cache::forget('stats.centersCount');
        Cache::forget('stats.centersOnReviewCount');
    }

    /**
     * Handle the Center "restored" event.
     */
    public function restored(Center $center): void
    {
        Cache::forget('stats.centersCount');
        Cache::forget('stats.centersOnReviewCount');
    }

    /**
     * Handle the Center "force deleted" event.
     */
    public function forceDeleted(Center $center): void
    {
        //
    }
}
