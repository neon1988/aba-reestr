<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Models\Bulletin;
use App\Models\Center;
use App\Models\Conference;
use App\Models\Specialist;
use App\Models\User;
use App\Models\Webinar;
use App\Models\Worksheet;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
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
            return Specialist::inRandomOrder()->take(3)->get();
        });

        return view('home', compact('centers', 'specialists'));
    }

    public function contacts(Request $request): View
    {
        return view('contacts');
    }

    public function stat()
    {
        return response()->json([
            'specialistsCount' => Cache::rememberForever('stats.specialistsCount', function () {
                return Specialist::where('status', StatusEnum::Accepted)->count();
            }),
            'specialistsOnReviewCount' => Cache::rememberForever('stats.specialistsOnReviewCount', function () {
                return Specialist::where('status', StatusEnum::OnReview)->count();
            }),
            'centersCount' => Cache::rememberForever('stats.centersCount', function () {
                return Center::where('status', StatusEnum::Accepted)->count();
            }),
            'centersOnReviewCount' => Cache::rememberForever('stats.centersOnReviewCount', function () {
                return Center::where('status', StatusEnum::OnReview)->count();
            }),
            'usersCount' => Cache::rememberForever('stats.usersCount', function () {
                return User::count();
            }),
            'bulletinsCount' => Cache::rememberForever('stats.bulletinsCount', function () {
                return Bulletin::where('status', StatusEnum::Accepted)->count();
            }),
            'bulletinsOnReviewCount' => Cache::rememberForever('stats.bulletinsOnReviewCount', function () {
                return Bulletin::where('status', StatusEnum::OnReview)->count();
            }),
            'webinarsCount' => Cache::rememberForever('stats.webinarsCount', function () {
                return Webinar::count();
            }),
            'worksheetsCount' => Cache::rememberForever('stats.worksheetsCount', function () {
                return Worksheet::count();
            }),
            'conferencesCount' => Cache::rememberForever('stats.conferencesCount', function () {
                return Conference::count();
            }),
        ]);
    }

    public function privacyPolicy(): Factory|\Illuminate\Contracts\View\View|Application
    {
        return view('privacy-policy');
    }
}
