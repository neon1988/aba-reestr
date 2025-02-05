<?php

namespace Tests\Feature\Payments\YooKassa;

use App\Enums\PaymentProvider;
use App\Enums\SubscriptionLevelEnum;
use App\Models\Payment;
use App\Models\User;
use App\Services\YooKassaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;
use YooKassa\Model\Notification\NotificationEventType;

class YooKassaWebhookTest extends TestCase
{
    use RefreshDatabase;

    protected YooKassaService $yooKassaMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->yooKassaMock = Mockery::mock(YooKassaService::class);
        $this->app->instance(YooKassaService::class, $this->yooKassaMock);
    }

    public function getObject($id, $subscription_type = SubscriptionLevelEnum::ParentsAndRelated)
    {
        return [
            'id' => $id,
            'status' => 'succeeded',
            'recipient' => [
                "account_id" => "100500",
                "gateway_id" => "100700"
            ], // Можно заменить на mock объекта RecipientInterface
            'amount' => [
                'value' => '1000.00',
                'currency' => 'RUB'
            ],
            'description' => 'Оплата подписки',
            "payment_method" => [
                "type" => "bank_card",
                "id" => "22e12f66-000f-5000-8000-18db351245c7",
                "saved" => false,
                "card" => [
                    "first6" => "555555",
                    "last4" => "4444",
                    "expiry_month" => "07",
                    "expiry_year" => "2022",
                    "card_type" => "Mir",
                    "card_product" => [
                        "code" => "MCP",
                        "name" => "MIR Privilege"
                    ],
                    "issuer_country" => "RU",
                    "issuer_name" => "Sberbank"
                ],
                "title" => "Bank card *4444"
            ], // Можно заменить на mock AbstractPaymentMethod
            'createdAt' => "2018-07-18T10:51:18.139Z",
            'capturedAt' => "2018-07-18T10:51:18.139Z",
            'expiresAt' => "2018-07-18T10:51:18.139Z",
            'confirmation' => null, // Можно заменить на mock AbstractConfirmation
            'refundedAmount' => [
                'value' => '0.00',
                'currency' => 'RUB'
            ],
            'paid' => true,
            'refundable' => false,
            'metadata' => [
                'order_id' => 'ORDER_123',
                'subscription_type' => SubscriptionLevelEnum::fromValue($subscription_type)->key
            ],
            'test' => false,
            'cancellationDetails' => null, // Можно заменить на mock CancellationDetailsInterface
            'authorizationDetails' => null, // Можно заменить на mock AuthorizationDetailsInterface
            'transfers' => [],
            'incomeAmount' => [
                'value' => '950.00',
                'currency' => 'RUB'
            ],
            'deal' => null, // Можно заменить на mock PaymentDealInfo
            'merchantCustomerId' => 'customer_789',
            'invoiceDetails' => null // Можно заменить на mock PaymentInvoiceDetails
        ];
    }

    /** @test */
    public function it_rejects_request_from_untrusted_ip()
    {
        $this->yooKassaMock->shouldReceive('getClient->isNotificationIPTrusted')
            ->andReturn(false);

        $response = $this->postJson(route('yookassa.webhook'),
            [
                "id" => "e44e8088-bd73-43b1-959a-954f3a7d0c54",
                'event' => 'payment.succeeded',
                "url" => "https://www.example.com/notification_url"
            ]);

        $response->assertStatus(400)->assertJson(['message' => 'Untrusted IP']);
    }

    /** @test */
    public function it_processes_successful_payment_and_upgrades_subscription()
    {
        $this->yooKassaMock->shouldReceive('getClient->isNotificationIPTrusted')
            ->andReturn(true);

        $subscription = SubscriptionLevelEnum::Specialists;

        $payment = Payment::factory()
            ->for(User::factory()->state([
                'subscription_level' => SubscriptionLevelEnum::Free,
                'subscription_ends_at' => null
            ]))
            ->create();

        $user = $payment->user;

        $this->assertEquals(SubscriptionLevelEnum::Free, $user->subscription_level);
        $this->assertEquals(null, $user->subscription_ends_at);

        $payload = $this->getObject($payment->payment_id, $subscription);

        $response = $this->postJson(route('yookassa.webhook'), [
            'event' => NotificationEventType::PAYMENT_SUCCEEDED,
            "url" => "https://www.example.com/notification_url",
            'object' => $payload
        ])
            ->assertStatus(200)
            ->assertJson(['message' => 'OK']);

        $user->refresh();

        $this->assertEquals($subscription, $user->subscription_level);
        $this->assertTrue($user->subscription_ends_at->isFuture());

        $purchasedSubscription = $user->purchasedSubscriptions()->first();
        $this->assertNotNull($purchasedSubscription);
    }

    /** @test */
    public function it_logs_waiting_for_capture_event()
    {
        $this->yooKassaMock->shouldReceive('getClient->isNotificationIPTrusted')
            ->andReturn(true);

        $subscription = SubscriptionLevelEnum::Specialists;

        $payment = Payment::factory()
            ->create();

        $user = $payment->user;

        $payload = $this->getObject($payment->payment_id, $subscription);

        $response = $this->postJson(route('yookassa.webhook'), [
            'event' => NotificationEventType::PAYMENT_WAITING_FOR_CAPTURE,
            "url" => "https://www.example.com/notification_url",
            'object' => $payload
        ])
            ->assertStatus(200)
            ->assertJson(['message' => 'OK']);
    }

    /** @test */
    public function it_logs_canceled_payment()
    {
        $this->yooKassaMock->shouldReceive('getClient->isNotificationIPTrusted')
            ->andReturn(true);

        $payment = Payment::factory()->create([
            'payment_provider' => PaymentProvider::YooKassa
        ]);

        $payload = $this->getObject($payment->payment_id);

        $response = $this->postJson(route('yookassa.webhook'), [
            'event' => NotificationEventType::PAYMENT_CANCELED,
            "url" => "https://www.example.com/notification_url",
            'object' => $payload
        ])
            ->assertStatus(200)
            ->assertJson(['message' => 'OK']);

        $response->assertStatus(200)->assertJson(['message' => 'OK']);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
