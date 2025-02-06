<?php

namespace App\Http\Controllers;

use App\Enums\CurrencyEnum;
use App\Enums\PaymentProvider;
use App\Enums\PaymentStatusEnum;
use App\Enums\SubscriptionLevelEnum;
use App\Models\Payment;
use App\Models\PurchasedSubscription;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\YooKassaService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use YooKassa\Model\Notification\NotificationFactory;
use Illuminate\Support\Facades\Log;
use YooKassa\Model\Notification\NotificationEventType;

class YooKassaController extends Controller
{
    protected YooKassaService $yooKassaService;

    public function __construct(YooKassaService $yooKassaService)
    {
        $this->yooKassaService = $yooKassaService;
    }

    public function buySubscription(Request $request, int $type)
    {
        if (!SubscriptionLevelEnum::hasValue($type))
            abort(404, 'Подписка не найдена');

        $subscription = SubscriptionLevelEnum::coerce($type);

        if ($subscription->getPrice() == 0)
            abort(403, 'Подписка должна быть платной');

        $payment = Payment::create(
            [
                'payment_provider' => PaymentProvider::YooKassa,
                'user_id' => Auth::id(),
                'amount' => $subscription->getPrice(),
                'currency' => CurrencyEnum::RUB,
                'status' => PaymentStatusEnum::fromValue(PaymentStatusEnum::CANCELED)->key,
                'meta' => []
            ]
        );

        $response = $this->yooKassaService->createPayment(
            $subscription->getPrice(),
            route('payments.show', ['payment' => $payment->id]),
            'Оплата подписки "'.$subscription->description.'"',
            [
                'user_id' => Auth::id(),
                'subscription_type' => $subscription->key
            ]
        );

        if (empty($response))
            throw new \Exception('Ошибка создания платежа');

        $payment->update([
            'payment_id' => $response->getId(),
            'payment_provider' => PaymentProvider::YooKassa,
            'amount' => $subscription->getPrice(),
            'currency' => CurrencyEnum::RUB,
            'status' => $response->getStatus(),
            'payment_method' => $response->getPaymentMethod(),
            'meta' => $response->toArray()
        ]);

        if ($response->getConfirmation()->getConfirmationUrl()) {
            return redirect($response->getConfirmation()->getConfirmationUrl());
        }

        return back()->with('error', 'Ошибка при создании платежа');
    }

    public function paymentShow(Payment $payment)
    {
        $response = $this->yooKassaService->getPaymentInfo($payment->payment_id);

        if (!$response)
            abort(404);

        $payment->update([
            'status' => $response->getStatus(),
            'payment_method' => optional($response->getPaymentMethod())->getType(),
            'meta' => $response->toArray()
        ]);

        if ($payment->status->is(PaymentStatusEnum::SUCCEEDED))
        {
            $this->createActivateSubscription($payment);
            $payment->refresh();
            return view('payments.success', compact('payment'));
        }

        return view('payments.not_completed', [
            'paymentUrl' => $response->getConfirmation()->getConfirmationUrl(),
            'payment' => $payment
        ]);
    }

    public function handleWebhook(Request $request)
    {
        try {
            if (!$this->yooKassaService->getClient()->isNotificationIPTrusted($request->ip())) {
                Log::warning('Untrusted webhook request', ['ip' => $request->ip()]);
                return response()->json(['message' => __('Untrusted IP')], 400);
            }

            $source = $request->getContent();
            $data = json_decode($source, true);

            $factory = new NotificationFactory();
            $notification = $factory->factory($data);

            $response = $notification->getObject();
            $paymentId = $response->getId();

            $payment = Payment::where('payment_provider', PaymentProvider::YooKassa)
                ->where('payment_id', $paymentId)
                ->firstOrFail();

            $payment->update([
                'status' => $response->getStatus(),
                'payment_method' => $response->getPaymentMethod()->getType(),
                'meta' => $response->toArray()
            ]);

            switch ($notification->getEvent()) {
                case NotificationEventType::PAYMENT_SUCCEEDED:
                    Log::info('Payment succeeded', ['paymentId' => $paymentId]);
                    $user = $payment->user;

                    if ($user instanceof User)
                    {
                        if (array_key_exists('subscription_type', $payment->meta['metadata']))
                        {
                            $this->createActivateSubscription($payment);
                        }
                    }

                    break;

                case NotificationEventType::PAYMENT_WAITING_FOR_CAPTURE:
                    Log::info('Payment waiting for capture', ['paymentId' => $paymentId]);
                    break;

                case NotificationEventType::PAYMENT_CANCELED:
                    Log::info('Payment canceled', ['paymentId' => $paymentId]);
                    break;

                case NotificationEventType::REFUND_SUCCEEDED:
                    Log::info('Refund succeeded', [
                        'refundId' => $response->getId(),
                        'paymentId' => $response->getPaymentId()
                    ]);
                    break;

                default:
                    Log::warning('Unknown event type', ['event' => $notification->getEvent()]);
                    return response()->json(['message' => __('Unknown event')], 400);
            }

            return response()->json(['message' => 'OK'], 200);
        } catch (\Exception $e) {
            throw $e;
            Log::error('Webhook processing error', ['error' => $e->getMessage()]);
            return response()->json(['message' => __('Error processing webhook')], 400);
        }
    }

    public function createActivateSubscription(Payment $payment)
    {
        return DB::transaction(function () use ($payment) {
            $subscription = PurchasedSubscription::updateOrCreate(
                [
                    'payment_id' => $payment->id,
                ],
                [
                    'user_id' => $payment->user->id,
                    'days' => 365,
                    'subscription_level' => SubscriptionLevelEnum::fromKey($payment->meta['metadata']['subscription_type']),
                    'amount' => $payment->amount,
                    'currency' => $payment->currency,
                ]
            );

            if (!$subscription->isActivated())
                $subscription->activate();

            if (Auth::check())
                if (Auth::user()->is($subscription->user) or Auth::user()->is($payment->user))
                    Auth::user()->refresh();

            return $subscription;
        });
    }

    public function paymentCancel(Payment $payment)
    {
        $payment->update([
            'status' => PaymentStatusEnum::fromValue(PaymentStatusEnum::CANCELED)->key
        ]);

        return back();
    }
}
