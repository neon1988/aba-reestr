<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\PurchasedSubscription;
use App\Models\Specialist;
use App\Models\User;
use App\Notifications\ConferenceInvitation;
use App\Notifications\ConferenceInvitationNotification;
use App\Notifications\SpecialistApprovedNotification;
use App\Notifications\SubscriptionActivatedNotification;
use App\Notifications\SupervisionInvitation;
use App\Notifications\SupervisionReminder;
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
            $user = User::factory()
                ->create();

            $conference = Conference::findOrFail(14);

            $message = (new ConferenceInvitationNotification($conference))->toMail($user);

            $markdown = new Markdown(view(), config('mail.markdown'));

            return $markdown->render('vendor.notifications.email', $message->toArray());
        } else {
            abort(Response::HTTP_NOT_FOUND);
        }
    }
}
