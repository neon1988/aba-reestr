<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PurchasedSubscription;
use App\Models\User;
use App\Models\Payment;
use App\Enums\SubscriptionLevelEnum;
use App\Enums\CurrencyEnum;
use Carbon\Carbon;

class PurchasedSubscriptionFactory extends Factory
{
    protected $model = PurchasedSubscription::class;

    public function definition(): array
    {
        return [
            'activated_at' => null,
            'user_id' => User::factory(),
            'payment_id' => Payment::factory(),
            'days' => 365,
            'subscription_level' => $this->faker->randomElement(SubscriptionLevelEnum::getValues()),
            'amount' => $this->faker->randomFloat(2, 50, 500), // Сумма от 50 до 500
            'currency' => $this->faker->randomElement(CurrencyEnum::getValues()),
        ];
    }

    // ➤ Если нужно задать конкретного пользователя
    public function paid(): PurchasedSubscriptionFactory
    {
        return $this->state(fn (array $attributes) => [
            'subscription_level' => $this->faker->randomElement([SubscriptionLevelEnum::A, SubscriptionLevelEnum::B, SubscriptionLevelEnum::C]),
        ]);
    }
}
