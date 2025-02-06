<?php

namespace App\Models;

use App\Enums\PaymentStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

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

        if ($this->payment->status != PaymentStatusEnum::SUCCEEDED)
            throw new \LogicException(
                'Payment is ' . PaymentStatusEnum::getDescription($this->payment->status));

        DB::transaction(function () {
            $now = Carbon::now();

            if ($this->user->isSubscriptionActive()) {
                if ($this->user->subscription_level != $this->subscription_level) {
                    throw new \LogicException(
                        'Активна подписка ' . PaymentStatusEnum::getDescription($this->user->subscription_level) .
                        ' до ' . $this->user->subscription_ends_at
                    );
                } else {
                    $subscription_ends_at = $this->user->subscription_ends_at->addDays($this->days);
                }
            } else {
                $subscription_ends_at = $now->addDays($this->days);
            }

            $this->activated_at = $now;
            $this->save();

            $this->user->subscription_level = $this->subscription_level;
            $this->user->subscription_ends_at = $subscription_ends_at;
            $this->user->save();
        });
    }
}
