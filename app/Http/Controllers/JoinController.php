<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Models\Center;
use App\Models\Country;
use App\Models\Specialist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class JoinController extends Controller
{
    public function join(Request $request): \Illuminate\Http\RedirectResponse|View
    {
        $specialist = Auth::user()->createdSpecialists()->whereStatusIn([StatusEnum::Accepted, StatusEnum::OnReview])->first();

        if (!empty($specialist))
            return redirect()->route('specialists.show', compact('specialist'));

        $center = Auth::user()->createdCenters()->whereStatusIn([StatusEnum::Accepted, StatusEnum::OnReview])->first();

        if (!empty($center))
            return redirect()->route('centers.show', compact('center'));

        return view('join.join');
    }

    public function specialist(Request $request)
    {
        $countries = Country::orderBy('name', 'asc')->get();

        return view('join.specialist', ['countries' => $countries]);
    }

    public function center(Request $request): View
    {
        $countries = Country::orderBy('name', 'asc')->get();

        return view('join.center', ['countries' => $countries]);
    }
}
