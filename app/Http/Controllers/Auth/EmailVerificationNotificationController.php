<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('profile.edit', absolute: false));
        }

        $request->user()->setLastVerificationEmailSentTime(Carbon::now());

        session(['last_verification_email_sent_time' => now()]);

        return back()->with('status', 'verification-link-sent');
    }
}
