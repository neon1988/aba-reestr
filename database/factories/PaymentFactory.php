<?php

namespace Database\Factories;

use App\Enums\CurrencyEnum;
use App\Enums\PaymentProvider;
use App\Enums\PaymentStatusEnum;
use App\Enums\SubscriptionLevelEnum;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'payment_id' => $this->faker->uuid,
            'payment_provider' => $this->faker->randomElement(PaymentProvider::getValues()),
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'currency' => $this->faker->randomElement(CurrencyEnum::getValues()),
            'status' => $this->faker->randomElement(PaymentStatusEnum::getKeys()),
            'payment_method' => $this->faker->randomElement(['card', 'bank_transfer', 'paypal', 'crypto']),
            'meta' => ['metadata' => ['subscription_type' => $this->faker->randomElement(SubscriptionLevelEnum::getValues())]],
        ];
    }

    // ➤ Если нужно задать конкретного пользователя
    public function forUser(User $user)
    {
        return $this->state(fn(array $attributes) => [
            'user_id' => $user->id,
        ]);
    }

    public function withSubscription()
    {
        return $this->afterCreating(function (Payment $payment) {
            $subscription = \App\Models\PurchasedSubscription::factory()
                ->paid()
                ->create([
                    'payment_id' => $payment->id,
                    'user_id' => $payment->user_id,
                ]);

            $payment->purchases()->create([
                'purchasable_id' => $subscription->id,
                'purchasable_type' => \App\Models\PurchasedSubscription::class,
            ]);
        });
    }
}
