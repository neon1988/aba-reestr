<?php

namespace App\Observers;

use App\Models\Bulletin;
use Illuminate\Support\Facades\Cache;

class BulletinObserver
{
    /**
     * Handle the Bulletin "created" event.
     */
    public function created(Bulletin $bulletin): void
    {
        Cache::forget('stats.bulletinsCount');
        Cache::forget('stats.bulletinsOnReviewCount');
    }

    /**
     * Handle the Bulletin "updated" event.
     */
    public function updated(Bulletin $bulletin): void
    {
        //
    }

    /**
     * Handle the Bulletin "deleted" event.
     */
    public function deleted(Bulletin $bulletin): void
    {
        Cache::forget('stats.bulletinsCount');
        Cache::forget('stats.bulletinsOnReviewCount');
    }

    /**
     * Handle the Bulletin "restored" event.
     */
    public function restored(Bulletin $bulletin): void
    {
        Cache::forget('stats.bulletinsCount');
        Cache::forget('stats.bulletinsOnReviewCount');
    }

    /**
     * Handle the Bulletin "force deleted" event.
     */
    public function forceDeleted(Bulletin $bulletin): void
    {
        Cache::forget('stats.bulletinsCount');
        Cache::forget('stats.bulletinsOnReviewCount');
    }
}
