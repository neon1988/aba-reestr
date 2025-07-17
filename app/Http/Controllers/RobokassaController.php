<?php

namespace App\Http\Controllers;

use App\Enums\CurrencyEnum;
use App\Enums\PaymentProvider;
use App\Enums\PaymentStatusEnum;
use App\Enums\SubscriptionLevelEnum;
use App\Jobs\ActivateSubscription;
use App\Models\Conference;
use App\Models\Payment;
use App\Models\PurchasedSubscription;
use App\Models\User;
use App\Models\Webinar;
use App\Models\Worksheet;
use App\Services\RobokassaService;
use App\Services\SubscriptionPriceService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Relations\Relation;

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
    public function buySubscription(Request $request, SubscriptionPriceService $service, int $type)
    {
        $this->authorize('purchaseSubscription', User::class);

        if (!SubscriptionLevelEnum::hasValue($type))
            abort(404, 'Подписка не найдена');

        $subscriptionType = SubscriptionLevelEnum::coerce($type);

        if ($subscriptionType->getPrice() == 0)
            abort(403, 'Подписка должна быть платной');

        $finalPrice = $service->getFinalPrice(SubscriptionLevelEnum::coerce($subscriptionType));

        $payment = Payment::create(
            [
                'payment_id' => null,
                'payment_provider' => PaymentProvider::RoboKassa,
                'user_id' => Auth::id(),
                'amount' => $finalPrice,
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
                'amount' => $finalPrice,
                'currency' => CurrencyEnum::RUB,
            ]
        );

        $payment->purchases()->create([
            'purchasable_id' => $subscription->id,
            'purchasable_type' => PurchasedSubscription::class,
        ]);

        $description = 'Доступ к материалам по тарифу ' . $subscriptionType->key;

        $paymentUrl = $this->robokassaService->createPayment(
            $finalPrice,
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

    public function buy(Request $request, string $type, string $id): RedirectResponse
    {
        $class = Relation::getMorphedModel($type);

        if (empty($class) or !class_exists($class))
            abort(404, __('Invalid purchase type.'));

        $purchasable = $class::findOrFail($id);

        $this->authorize('buy', $purchasable);

        $price = $purchasable->price;

        $payment = Payment::create(
            [
                'payment_id' => null,
                'payment_provider' => PaymentProvider::RoboKassa,
                'user_id' => Auth::id(),
                'amount' => $price,
                'currency' => CurrencyEnum::RUB,
                'status' => PaymentStatusEnum::fromValue(PaymentStatusEnum::PENDING)->key,
                'meta' => null
            ]
        );
        $payment->payment_id = $payment->id;
        $payment->save();

        $payment->purchases()->create([
            'purchasable_id' => $purchasable->id,
            'purchasable_type' => $class,
        ]);

        $description = $purchasable->getPurchasableDescription();

        $paymentUrl = $this->robokassaService->createPayment(
            $price,
            $payment->id,
            $description,
            [
                "items" => [
                    [
                        "name" => $description,
                        "quantity" => 1,
                        "sum" => $price,
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
            'meta' => $validated
        ]);

        $this->checkActivateSubscription($payment);

        foreach ($payment->purchases()->with('purchasable')->get() as $purchase) {
            if ($purchase->purchasable instanceof Webinar)
                return redirect()->route('webinars.show', $purchase->purchasable);
            if ($purchase->purchasable instanceof Worksheet)
                return redirect()->route('worksheets.show', $purchase->purchasable);
            if ($purchase->purchasable instanceof Conference)
                return redirect()->route('conferences.show', $purchase->purchasable);
        }

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
        if (!$this->robokassaService->isValidIP($request->ip()))
            abort(403, 'Untrusted Robokassa IP ' . $request->ip());

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

        Log::info('Robokassa payment '.$id.' show', $data);

        var_dump($data);
    }
}
