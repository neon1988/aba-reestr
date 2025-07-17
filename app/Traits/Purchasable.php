<?php

namespace App\Traits;

use App\Enums\PaymentStatusEnum;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Purchasable
{
    public function isPaid(): bool
    {
        return (float) $this->price > 0;
    }

    /**
     * Связь: все покупки этого товара
     */
    public function purchases(): MorphMany
    {
        return $this->morphMany(Purchase::class, 'purchasable');
    }

    protected array $purchaseCache = [];

    public function isPurchasedByUser(User $user): bool
    {
        $cacheKey = $user->id;

        if (!array_key_exists($cacheKey, $this->purchaseCache)) {
            $this->purchaseCache[$cacheKey] = $this->purchases()
                ->whereHas('payment', function (Builder $query) use ($user) {
                    $query->where('user_id', $user->id)
                        ->where('status', PaymentStatusEnum::SUCCEEDED);
                })->exists();
        }

        return $this->purchaseCache[$cacheKey];
    }
}
