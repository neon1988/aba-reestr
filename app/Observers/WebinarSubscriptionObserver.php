<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Webinar;
use App\Models\WebinarSubscription;

class WebinarSubscriptionObserver
{
    /**
     * Handle the WebinarSubscription "created" event.
     */
    public function created(WebinarSubscription $webinarSubscription): void
    {
        if ($webinarSubscription->webinar instanceof Webinar)
            $webinarSubscription->webinar->updateSubscribersCount();
        if ($webinarSubscription->user instanceof User)
            $webinarSubscription->user->updateWebinarsCount();
    }

    /**
     * Handle the WebinarSubscription "updated" event.
     */
    public function updated(WebinarSubscription $webinarSubscription): void
    {
        //
    }

    /**
     * Handle the WebinarSubscription "deleted" event.
     */
    public function deleted(WebinarSubscription $webinarSubscription): void
    {
        if ($webinarSubscription->webinar instanceof Webinar)
            $webinarSubscription->webinar->updateSubscribersCount();
        if ($webinarSubscription->user instanceof User)
            $webinarSubscription->user->updateWebinarsCount();
    }

    /**
     * Handle the WebinarSubscription "restored" event.
     */
    public function restored(WebinarSubscription $webinarSubscription): void
    {
        if ($webinarSubscription->webinar instanceof Webinar)
            $webinarSubscription->webinar->updateSubscribersCount();
        if ($webinarSubscription->user instanceof User)
            $webinarSubscription->user->updateWebinarsCount();
    }

    /**
     * Handle the WebinarSubscription "force deleted" event.
     */
    public function forceDeleted(WebinarSubscription $webinarSubscription): void
    {
        //
    }
}
