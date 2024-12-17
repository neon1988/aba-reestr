<?php

namespace App\Observers;

use App\Models\Conference;
use Illuminate\Support\Facades\Cache;

class ConferenceObserver
{
    /**
     * Handle the Conference "created" event.
     */
    public function created(Conference $conference): void
    {
        Cache::forget('stats.conferencesCount');
        Cache::forget('stats.conferencesOnReviewCount');
    }

    /**
     * Handle the Conference "updated" event.
     */
    public function updated(Conference $conference): void
    {
        //
    }

    /**
     * Handle the Conference "deleted" event.
     */
    public function deleted(Conference $conference): void
    {
        Cache::forget('stats.conferencesCount');
        Cache::forget('stats.conferencesOnReviewCount');
    }

    /**
     * Handle the Conference "restored" event.
     */
    public function restored(Conference $conference): void
    {
        Cache::forget('stats.conferencesCount');
        Cache::forget('stats.conferencesOnReviewCount');
    }

    /**
     * Handle the Conference "force deleted" event.
     */
    public function forceDeleted(Conference $conference): void
    {
        Cache::forget('stats.conferencesCount');
        Cache::forget('stats.conferencesOnReviewCount');
    }
}
