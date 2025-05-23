<?php

namespace App\Http\Controllers;

use App\Enums\SubscriptionLevelEnum;
use App\Models\Country;
use App\Services\SubscriptionPriceService;
use Carbon\Carbon;
use Carbon\CarbonTimeZone;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JoinController extends Controller
{
    use AuthorizesRequests;

    public function join(Request $request, SubscriptionPriceService $service): RedirectResponse|View
    {
        if (Auth::check()) {
            $user = Auth::user();

            if (!$user->hasVerifiedEmail()) {
                return view('auth.verify-email');
            }

            if ($user->isSubscriptionActive()) {
                if ($user->isSpecialist())
                    return redirect()->route('specialists.show', Auth::user()->getSpecialistId());

                if ($user->isCenter())
                    return redirect()->route('centers.show', Auth::user()->getCenterId());

                abort(403, 'У вас уже активна подписка');
            }
        }

        $prices = [
            SubscriptionLevelEnum::A => [
                'base_price' => SubscriptionLevelEnum::coerce(SubscriptionLevelEnum::A)->getPrice(),
                'final_price' => $service->getFinalPrice(SubscriptionLevelEnum::coerce(SubscriptionLevelEnum::A))
            ],
            SubscriptionLevelEnum::B => [
                'base_price' => SubscriptionLevelEnum::coerce(SubscriptionLevelEnum::B)->getPrice(),
                'final_price' => $service->getFinalPrice(SubscriptionLevelEnum::coerce(SubscriptionLevelEnum::B))
            ],
            SubscriptionLevelEnum::C => [
                'base_price' => SubscriptionLevelEnum::coerce(SubscriptionLevelEnum::C)->getPrice(),
                'final_price' => $service->getFinalPrice(SubscriptionLevelEnum::coerce(SubscriptionLevelEnum::C))
            ],
        ];

        return view('join.join', compact('prices'));
    }

    public function discount_b_subscription_22(Request $request): RedirectResponse|View
    {
        session([
            'subscription_discount' => [
                SubscriptionLevelEnum::B => [
                    'percent' => 100 - (35 * 100 / 45), # 4500 р. => 3500 р.
                    'active_until' => Carbon::create(2025, 4, 21, 0, 0, 0, new CarbonTimeZone('Europe/Moscow'))
                ]
            ]
        ]);

        return redirect()
            ->route('join');
    }

    public function specialist(Request $request)
    {
        $this->authorize('createSpecialist', Auth::user());

        if (Auth::user()->isSpecialist())
            return redirect()->route('specialists.show', Auth::user()->getSpecialistId());

        $countries = Country::orderBy('name', 'asc')->get();
        $user = Auth::user();
        $photo = $user->photo;

        return view('join.specialist', compact('countries', 'user', 'photo'));
    }

    public function center(Request $request): View
    {
        return redirect()->route('home');

        $countries = Country::orderBy('name', 'asc')->get();
        $user = Auth::user();

        return view('join.center', ['countries' => $countries, 'user']);
    }
}
