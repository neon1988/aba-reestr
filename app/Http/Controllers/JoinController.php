<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Models\Country;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JoinController extends Controller
{
    public function join(Request $request): RedirectResponse|View
    {
        $user = Auth::user();

        if ($user->isSpecialist())
            return redirect()->route('specialists.show', Auth::user()->getSpecialistId());

        if ($user->isCenter())
            return redirect()->route('centers.show', Auth::user()->getCenterId());

        return view('join.join');
    }

    public function specialist(Request $request)
    {
        $countries = Country::orderBy('name', 'asc')->get();
        $user = Auth::user();

        return view('join.specialist', compact('countries', 'user'));
    }

    public function center(Request $request): View
    {
        $countries = Country::orderBy('name', 'asc')->get();
        $user = Auth::user();

        return view('join.center', ['countries' => $countries, 'user']);
    }
}
