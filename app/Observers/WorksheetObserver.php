<?php

namespace App\Observers;

use App\Models\Worksheet;
use Illuminate\Support\Facades\Cache;

class WorksheetObserver
{
    /**
     * Handle the Worksheet "created" event.
     */
    public function created(Worksheet $worksheet): void
    {
        Cache::forget('stats.worksheetsCount');
        Cache::forget('stats.worksheetsOnReviewCount');
    }

    /**
     * Handle the Worksheet "updated" event.
     */
    public function updated(Worksheet $worksheet): void
    {
        //
    }

    /**
     * Handle the Worksheet "deleted" event.
     */
    public function deleted(Worksheet $worksheet): void
    {
        Cache::forget('stats.worksheetsCount');
        Cache::forget('stats.worksheetsOnReviewCount');
    }

    /**
     * Handle the Worksheet "restored" event.
     */
    public function restored(Worksheet $worksheet): void
    {
        Cache::forget('stats.worksheetsCount');
        Cache::forget('stats.worksheetsOnReviewCount');
    }

    /**
     * Handle the Worksheet "force deleted" event.
     */
    public function forceDeleted(Worksheet $worksheet): void
    {
        Cache::forget('stats.worksheetsCount');
        Cache::forget('stats.worksheetsOnReviewCount');
    }
}
