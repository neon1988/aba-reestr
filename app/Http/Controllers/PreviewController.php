<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\User;
use App\Notifications\ConferenceInvitation;
use App\Notifications\ConferenceInvitationNotification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Mail\Markdown;
use Illuminate\Support\Facades\App;

class PreviewController extends Controller
{
    public function notification(Request $request)
    {
        if (App::environment(['local'])) {
            //dd(Auth::user()->getKey());
            $user = User::factory()
                ->create();

            $conference = Conference::factory()
                ->create();

            $message = (new ConferenceInvitationNotification($conference))->toMail($user);

            $markdown = new Markdown(view(), config('mail.markdown'));

            return $markdown->render('vendor.notifications.email', $message->toArray());
        } else {
            abort(Response::HTTP_NOT_FOUND);
        }
    }
}
