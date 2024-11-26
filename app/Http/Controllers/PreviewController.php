<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Mail\Markdown;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class PreviewController extends Controller
{
    public function notification(Request $request)
    {
        if (App::environment(['local'])) {
            //dd(Auth::user()->getKey());
            $user = Auth::user();

            $message = (new VerifyEmail())->toMail($user);

            $markdown = new Markdown(view(), config('mail.markdown'));

            return $markdown->render('vendor.notifications.email', $message->toArray());
        } else {
            abort(Response::HTTP_NOT_FOUND);
        }
    }
}