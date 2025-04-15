<?php

namespace App\Services;

use App\Enums\SubscriptionLevelEnum;
use Carbon\Carbon;

class SubscriptionPriceService
{
    public function getFinalPrice(SubscriptionLevelEnum $level): float
    {
        $basePrice = $level->getPrice();
        $discountData = session('subscription_discount', null);
        $discount = 0;

        // Проверяем, есть ли скидка и действительна ли она
        if ($discountData && isset($discountData['value'], $discountData['active_until'])) {
            $activeUntil = Carbon::parse($discountData['active_until']);
            if (Carbon::now()->lessThanOrEqualTo($activeUntil)) {
                $discount = $discountData['value'];
            } else {
                // Если скидка просрочена, удаляем её из сессии
                session()->forget('subscription_discount');
            }
        }

        return $basePrice * (1 - $discount / 100); // Скидка в процентах
    }
}
