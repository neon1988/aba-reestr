<?php

namespace App\Services;

use App\Enums\SubscriptionLevelEnum;
use Carbon\Carbon;

class SubscriptionPriceService
{
    public function getFinalPrice(SubscriptionLevelEnum $level): float
    {
        $discountData = session('subscription_discount', []);

        $basePrice = $level->getPrice();
        $percent = 0;

        foreach ($discountData as $subscription => $data)
        {
            if ($level->is($subscription))
            {
                $activeUntil = Carbon::parse($data['active_until']);
                if (Carbon::now()->lessThanOrEqualTo($activeUntil)) {
                    $percent = $data['percent'];
                }
            }
        }

        return $basePrice - ($basePrice * $percent / 100);
    }
}
