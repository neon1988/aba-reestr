<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\Specialist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class OtherController extends Controller
{
    public function home(Request $request): View
    {
        $centers = Cache::remember('home.centers', 60, function () {
            return Center::inRandomOrder()->take(3)->get();
        });

        $specialists = Cache::remember('home.specialists', 60, function () {
            return Specialist::inRandomOrder()->take(3)->get();;
        });

        return view('home', compact('centers', 'specialists'));
    }

    public function contacts(Request $request): View
    {
        return view('contacts');
    }
}
