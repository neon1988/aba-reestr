<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JoinController extends Controller
{
    public function join(Request $request): View
    {
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
