<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class OtherController extends Controller
{
    public function home(Request $request): View
    {
        return view('home');
    }

    public function contacts(Request $request): View
    {
        return view('contacts');
    }
}
