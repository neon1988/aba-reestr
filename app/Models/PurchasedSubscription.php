<?php

namespace App\Models;

use App\Enums\SubscriptionLevelEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchasedSubscription extends Model
{
    /** @use HasFactory<\Database\Factories\PurchasedSubscriptionFactory> */
    use HasFactory;

    protected $fillable = [
        'activated_at',
        'user_id',
        'payment_id',
        'days',
        'subscription_level',
        'amount',
        'currency',
    ];

    public function isActivated(): bool
    {
        return !empty($this->activated_at);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function activate(): void
    {
        if ($this->isActivated())
            throw new \LogicException('Already activated');

        $now = Carbon::now();

        $this->activated_at = $now;
        $this->save();

        $this->user->subscription_level = $this->subscription_level;
        $this->user->subscription_ends_at = $now->addDays($this->days);
        $this->user->save();
    }
}
