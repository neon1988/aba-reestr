<?php

namespace App\Http\Controllers\Auth;

use App\Enums\SubscriptionLevelEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        if (Auth::user()->isCenter())
            $next = route('centers.show', Auth::user()->getCenterId());
        elseif (Auth::user()->isSpecialist())
            $next = route('specialists.show', Auth::user()->getSpecialistId());
        else
        {
            if (Auth::user()->isSubscriptionActive())
            {
                $next = match (Auth::user()->subscription_level) {
                    SubscriptionLevelEnum::B => route('join.specialist'),
                    SubscriptionLevelEnum::C => route('join.center'),
                    default => route('home'),
                };
            }
            else
                $next = route('join');
        }

        if ($request->expectsJson())
        {
            return response([
                'message' => __('Login successful.'),
                'redirect_to' => $next
            ], 201);
        }
        else
        {
            return redirect()->intended($next);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
