<?php

namespace App\Http\Controllers;

use App\Enums\CurrencyEnum;
use App\Enums\PaymentProvider;
use App\Enums\PaymentStatusEnum;
use App\Enums\SubscriptionLevelEnum;
use App\Jobs\ActivateSubscription;
use App\Models\Payment;
use App\Models\PurchasedSubscription;
use App\Models\User;
use App\Services\RobokassaService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RobokassaController extends Controller
{
    use AuthorizesRequests;

    protected RobokassaService $robokassaService;

    public function __construct(RobokassaService $robokassaService)
    {
        $this->robokassaService = $robokassaService;
    }

    /**
     * @throws AuthorizationException
     */
    public function buySubscription(Request $request, int $type)
    {
        $this->authorize('purchaseSubscription', User::class);

        if (!SubscriptionLevelEnum::hasValue($type))
            abort(404, 'Подписка не найдена');

        $subscriptionType = SubscriptionLevelEnum::coerce($type);

        if ($subscriptionType->getPrice() == 0)
            abort(403, 'Подписка должна быть платной');

        $payment = Payment::create(
            [
                'payment_id' => null,
                'payment_provider' => PaymentProvider::RoboKassa,
                'user_id' => Auth::id(),
                'amount' => $subscriptionType->getPrice(),
                'currency' => CurrencyEnum::RUB,
                'status' => PaymentStatusEnum::fromValue(PaymentStatusEnum::PENDING)->key,
                'meta' => null
            ]
        );
        $payment->payment_id = $payment->id;
        $payment->save();

        $subscription = PurchasedSubscription::create(
            [
                'activated_at' => null,
                'payment_id' => $payment->id,
                'days' => 365,
                'user_id' => Auth::id(),
                'subscription_level' => SubscriptionLevelEnum::coerce($type),
                'amount' => $subscriptionType->getPrice(),
                'currency' => CurrencyEnum::RUB,
            ]
        );

        $payment->purchases()->create([
            'purchasable_id' => $subscription->id,
            'purchasable_type' => PurchasedSubscription::class,
        ]);

        $description = 'Доступ к материалам по тарифу ' . $subscriptionType->key;

        $paymentUrl = $this->robokassaService->createPayment(
            $subscriptionType->getPrice(),
            $payment->id,
            $description,
            [
                "items" => [
                    [
                        "name" => $description,
                        "quantity" => 1,
                        "sum" => $subscription->amount,
                        "payment_method" => "full_payment",
                        "payment_object" => "service",
                        "tax" => "none"
                    ]
                ]
            ]
        );

        return response()->redirectTo($paymentUrl);
    }

    /**
     * @throws \Exception
     */
    public function paymentSuccess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'OutSum' => 'required|numeric|min:0.01',
            'InvId' => 'required|integer|min:1',
            'SignatureValue' => 'required|string',
            'Culture' => 'nullable|string|in:ru,en'
        ]);

        if ($validator->fails()) {
            Log::error('Invalid Robokassa data', [
                'errors' => $validator->errors()->toArray(),
                'request' => $request->all(),
            ]);

            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $validated = $validator->validated();

        if (!$this->robokassaService->isValidSuccessSignature($validated)) {
            abort(400, 'Invalid Robokassa signature', ['request' => $validated]);
        }

        Log::info('Robokassa payment success', ['request' => $validated]);

        $payment = Payment::where('user_id', Auth::id())
            ->where('payment_provider', PaymentProvider::RoboKassa)
            ->findOrFail($validated['InvId']);

        $payment->update([
            'status' => PaymentStatusEnum::fromValue(PaymentStatusEnum::SUCCEEDED),
            'payment_method' => $validated['PaymentMethod'] ?? null,
            'meta' => $validated
        ]);

        $this->checkActivateSubscription($payment);

        return view('payments.success');
    }

    public function paymentFailed(Request $request): View|Factory|Application
    {
        Log::error('Payment failed', ['user_id' => Auth::id(), 'params' => $request->all()]);

        return view('payments.failed');
    }

    public function checkActivateSubscription(Payment $payment): void
    {
        if ($payment->status->is(PaymentStatusEnum::SUCCEEDED)) {
            foreach ($payment->purchases()->with('purchasable')->get() as $purchase) {
                if ($purchase->purchasable instanceof PurchasedSubscription)
                    dispatch_sync(new ActivateSubscription($purchase->purchasable));
            }
        }
    }

    /**
     * Обработка уведомления об оплате (ResultURL).
     */
    public function handleWebhook(Request $request)
    {
        if (!$this->robokassaService->isValidIP($request->ip())) {
            abort(403, 'Untrusted Robokassa IP ' . $request->ip());
        }

        $validator = Validator::make($request->all(), [
            'OutSum' => 'required|numeric|min:0.01', # OutSum=1.000000
            'InvId' => 'required|integer|min:1', #InvId=55
            'crc' => 'required|string', #crc=2745738D76E6E357D5A9FEF3FCB916C7
            'Fee' => 'required|numeric', #Fee=0.030000
            'EMail' => 'nullable|email|max:255', #EMail=test@test.com
            'SignatureValue' => 'required|string', #SignatureValue=2745738D76E6E357D5A9FEF3FCB916C7
            'IncSum' => 'required|numeric', #IncSum=1.000000
            'PaymentMethod' => 'nullable|string|max:255', #PaymentMethod=PayButton
            'IncCurrLabel' => 'required|string|max:255', #IncCurrLabel=SBPPSR
        ]);

        if ($validator->fails())
            throw ValidationException::withMessages($validator->errors()->toArray());

        $validated = $validator->validated();

        Log::info('Robokassa webhook received', ['data' => $validated]);

        if (!$this->robokassaService->isValidResultSignature($validated))
            abort(400, 'Invalid Robokassa signature', ['request' => $validated]);

        $payment = Payment::where('payment_provider', PaymentProvider::RoboKassa)
            ->findOrFail($validated['InvId']);

        $payment->update([
            'amount' => $validated['OutSum'],
            'status' => PaymentStatusEnum::coerce(PaymentStatusEnum::SUCCEEDED),
            'payment_method' => $validated['PaymentMethod'] ?? null,
            'currency' => CurrencyEnum::RUB,
            'meta' => $validated,
        ]);

        $this->checkActivateSubscription($payment);

        // Отвечаем Robokassa форматом "OK<InvId>"
        return response("OK$payment->id", Response::HTTP_OK);
    }

    public function paymentShow(string $id)
    {
        $payment = Payment::where('user_id', Auth::id())
            ->where('payment_provider', PaymentProvider::RoboKassa)
            ->findOrFail($id);

        $data = $this->robokassaService->checkPaymentStatus($payment->id);

        Log::info('Robokassa payment show', $data);

        var_dump($data);
    }
}
