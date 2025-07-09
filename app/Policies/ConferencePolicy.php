<?php

namespace App\Policies;

use App\Models\Conference;
use App\Models\User;
use App\Models\Webinar;
use Carbon\Carbon;
use Illuminate\Auth\Access\Response;

class ConferencePolicy extends Policy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Conference $conference): Response
    {
        if ($user->isStaff())
            return Response::allow();
        if ($conference->isPaid()) {
            if (!$user->isSubscriptionActive())
                return Response::deny(__("You don't have a subscription or your subscription is inactive."));
            if (!$conference->isAvailableForSubscription($user->subscription_level))
                return Response::deny(__("Unavailable for your subscription"));
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        if ($user->isStaff())
            return Response::allow();
        return Response::deny(__('You are not allowed to create a conference.'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Conference $conference): Response
    {
        if ($user->isStaff())
            return Response::allow();
        return Response::deny(__('You are not allowed to update this conference.'));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Conference $conference): Response
    {
        if ($user->isStaff())
            return Response::allow();
        return Response::deny(__('You are not allowed to delete this conference.'));
    }

    /**
     * Determine whether the user can toggle subscription.
     */
    public function toggleSubscription(User $user, Conference $conference): Response
    {
        if ($user->isStaff())
            return Response::allow();
        if ($conference->isPaid()) {
            if (!$user->isSubscriptionActive())
                return Response::deny(__("You don't have a subscription or your subscription is inactive."));
            if (!$conference->isAvailableForSubscription($user->subscription_level))
                return Response::deny(__("Unavailable for your subscription"));
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can watch the conference.
     */
    public function watch(User $authUser, Conference $conference): Response
    {
        if (!$conference->hasRecordFile())
            return Response::deny(__("The conference has no record."));

        if (!$conference->isVideo())
            return Response::deny(__("You can only watch it if the file is a video file."));

        if ($authUser->isStaff())
            return Response::allow();

        if ($conference->isPaid()) {
            if (!$authUser->isSubscriptionActive())
                return Response::deny(__("You don't have a subscription or your subscription is inactive."));
            if (!$conference->isAvailableForSubscription($authUser->subscription_level))
                return Response::deny(__("Unavailable for your subscription"));
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can download the conference.
     */
    public function download(User $user, Conference $conference): Response
    {
        if ($user->isStaff())
            return Response::allow();
        if ($conference->isPaid()) {
            if (!$user->isSubscriptionActive())
                return Response::deny(__("You don't have a subscription or your subscription is inactive."));
            if (!$conference->isAvailableForSubscription($user->subscription_level))
                return Response::deny(__("Unavailable for your subscription"));
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can buy the conference.
     */
    public function buy(?User $authUser, Conference $conference): Response
    {
        if (!$conference->isPaid())
            return Response::deny(__("The conference is not paid."));

        if ($authUser->isStaff())
            return Response::deny();

        if ($conference->isPaid())
            if ($authUser->isSubscriptionActive())
                return Response::deny(__("You can't buy it because you already have a subscription"));

        return Response::allow();
    }

    /**
     * Determine whether the user can request participation
     */
    public function requestParticipation(User $user, Conference $conference): Response
    {
        if (empty($conference->registration_url))
            return Response::deny(__("There is no registration link in this conference."));
        if ($conference->isEnded())
            return Response::deny(__("The conference is ended"));
        if ($conference->hasRecordFile())
            return Response::deny(__("The conference is already on the record"));
        if ($user->isStaff())
            return Response::allow();
        if ($conference->isPaid())
        {
            if (!$user->isSubscriptionActive())
                return Response::deny(__("You don't have a subscription or your subscription is inactive."));
            if (!$conference->isAvailableForSubscription($user->subscription_level))
                return Response::deny(__("Unavailable for your subscription"));
        }

        return Response::allow();
    }

    public function sendInvitations(User $user, Conference $conference): Response
    {
        if (empty($conference->registration_url))
            return Response::deny(__("There is no registration link in this conference."));

        if (!$user->isStaff())
            return Response::deny(__("Only staff can send notifications."));

        if ($conference->isEnded())
            return Response::deny(__("The conference is ended"));

        if (!$conference->shouldNotifyAgain())
            return Response::deny(__("The notifications were sent very recently."));

        return Response::allow();
    }
}
