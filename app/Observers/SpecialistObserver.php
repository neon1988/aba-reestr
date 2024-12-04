<?php

namespace App\Observers;

use App\Models\Specialist;
use Illuminate\Support\Facades\Cache;

class SpecialistObserver
{
    /**
     * Handle the Specialist "created" event.
     */
    public function created(Specialist $specialist): void
    {
        Cache::forget('stats.specialistsCount');
        Cache::forget('stats.specialistsOnReviewCount');
    }

    /**
     * Handle the Specialist "updated" event.
     */
    public function updated(Specialist $specialist): void
    {
        //
    }

    /**
     * Handle the Specialist "deleted" event.
     */
    public function deleted(Specialist $specialist): void
    {
        Cache::forget('stats.specialistsCount');
        Cache::forget('stats.specialistsOnReviewCount');
    }

    /**
     * Handle the Specialist "restored" event.
     */
    public function restored(Specialist $specialist): void
    {
        Cache::forget('stats.specialistsCount');
        Cache::forget('stats.specialistsOnReviewCount');
    }

    /**
     * Handle the Specialist "force deleted" event.
     */
    public function forceDeleted(Specialist $specialist): void
    {
        //
    }
}
