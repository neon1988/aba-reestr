<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JoinController extends Controller
{
    use AuthorizesRequests;

    public function join(Request $request): RedirectResponse|View
    {
        if (Auth::check())
        {
            $user = Auth::user();

            if ($user->isSubscriptionActive())
            {
                if ($user->isSpecialist())
                    return redirect()->route('specialists.show', Auth::user()->getSpecialistId());

                if ($user->isCenter())
                    return redirect()->route('centers.show', Auth::user()->getCenterId());

                abort(403, 'У вас уже активна подписка');
            }
        }

        return view('join.join');
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
