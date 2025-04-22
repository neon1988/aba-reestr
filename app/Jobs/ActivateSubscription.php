<?php

namespace App\Jobs;

use App\Models\PurchasedSubscription;
use App\Models\User;
use App\Notifications\PromocodeNotification;
use App\Notifications\SubscriptionActivatedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class ActivateSubscription implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $uniqueFor = 3600;
    protected PurchasedSubscription $subscription;

    /**
     * Create a new job instance.
     */
    public function __construct(PurchasedSubscription $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->subscription->isActivated())
            return;

        $this->subscription->activate();

        if ($this->subscription->user instanceof User)
        {
            $this->subscription->user->notify(new SubscriptionActivatedNotification($this->subscription));
            $this->subscription->user->notify((new PromocodeNotification())->delay(now()->addMinute()));
        }

        $this->subscription->refresh();

        if (Auth::check() and $this->subscription->user instanceof User)
            if (Auth::user()->is($this->subscription->user))
                Auth::user()->refresh();
    }

    /**
     * Ограничиваем уникальность на уровне подписки.
     */
    public function uniqueId(): string
    {
        return 'activate_subscription_' . $this->subscription->id;
    }
}
