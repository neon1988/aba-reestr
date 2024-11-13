<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class JoinController extends Controller
{
    public function join(Request $request): View
    {
        return view('join.join');
    }

    public function specialist(Request $request): View
    {
        return view('join.specialist');
    }

    public function center(Request $request): View
    {
        return view('join.center');
    }
}
