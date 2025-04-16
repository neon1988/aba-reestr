<?php

namespace Tests\Feature\Services;

use App\Enums\SubscriptionLevelEnum;
use App\Services\SubscriptionPriceService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class SubscriptionPriceServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Зафиксировать "текущую" дату
        Carbon::setTestNow(Carbon::create(2025, 4, 16));
    }

    public function test_price_without_discount()
    {
        Session::put('subscription_discount', []);

        $service = new SubscriptionPriceService();
        $price = $service->getFinalPrice(SubscriptionLevelEnum::coerce(SubscriptionLevelEnum::B));

        $this->assertEquals(SubscriptionLevelEnum::coerce(SubscriptionLevelEnum::B)->getPrice(), $price);
    }

    public function test_price_with_active_discount()
    {
        Session::put('subscription_discount', [
            SubscriptionLevelEnum::B => [
                'percent' => 50,
                'active_until' => '2025-04-20',
            ]
        ]);

        $service = new SubscriptionPriceService();
        $price = $service->getFinalPrice(SubscriptionLevelEnum::coerce(SubscriptionLevelEnum::B));

        $this->assertEquals(SubscriptionLevelEnum::coerce(SubscriptionLevelEnum::B)->getPrice() / 2, $price);
    }

    public function test_price_with_expired_discount()
    {
        Session::put('subscription_discount', [
            SubscriptionLevelEnum::B => [
                'percent' => 50,
                'active_until' => '2025-04-15',
            ]
        ]);

        $service = new SubscriptionPriceService();
        $price = $service->getFinalPrice(SubscriptionLevelEnum::coerce(SubscriptionLevelEnum::B));

        $this->assertEquals(SubscriptionLevelEnum::coerce(SubscriptionLevelEnum::B)->getPrice(), $price); // скидка не применяется
    }
}
