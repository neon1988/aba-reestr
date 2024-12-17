<?php

namespace App\Observers;

use App\Models\Webinar;
use Illuminate\Support\Facades\Cache;

class WebinarObserver
{
    /**
     * Handle the Webinar "created" event.
     */
    public function created(Webinar $webinar): void
    {
        Cache::forget('stats.webinarsCount');
        Cache::forget('stats.webinarsOnReviewCount');
    }

    /**
     * Handle the Webinar "updated" event.
     */
    public function updated(Webinar $webinar): void
    {
        //
    }

    /**
     * Handle the Webinar "deleted" event.
     */
    public function deleted(Webinar $webinar): void
    {
        Cache::forget('stats.webinarsCount');
        Cache::forget('stats.webinarsOnReviewCount');
    }

    /**
     * Handle the Webinar "restored" event.
     */
    public function restored(Webinar $webinar): void
    {
        Cache::forget('stats.webinarsCount');
        Cache::forget('stats.webinarsOnReviewCount');
    }

    /**
     * Handle the Webinar "force deleted" event.
     */
    public function forceDeleted(Webinar $webinar): void
    {
        Cache::forget('stats.webinarsCount');
        Cache::forget('stats.webinarsOnReviewCount');
    }
}
