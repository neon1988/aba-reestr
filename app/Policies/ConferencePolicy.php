<?php

namespace App\Policies;

use App\Models\Conference;
use App\Models\User;
use App\Models\Webinar;
use Illuminate\Auth\Access\Response;

class ConferencePolicy extends Policy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Conference $conference): Response
    {
        if (!$user->isSubscriptionActive())
            return Response::deny(__("You don't have a subscription or your subscription is inactive."));

        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return Response::deny(__('You are not allowed to create a conference.'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Conference $conference): Response
    {
        return Response::deny(__('You are not allowed to update this conference.'));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Conference $conference): Response
    {
        return Response::deny(__('You are not allowed to delete this conference.'));
    }

    /**
     * Determine whether the user can toggle subscription.
     */
    public function toggleSubscription(User $user, Conference $conference): Response
    {
        if (!$user->isSubscriptionActive())
            return Response::deny(__("You don't have a subscription or your subscription is inactive."));

        return Response::allow();
    }

    /**
     * Determine whether the user can download the conference.
     */
    public function download(User $user, Conference $conference): Response
    {
        if (!$user->isSubscriptionActive())
            return Response::deny(__("You don't have a subscription or your subscription is inactive."));

        return Response::allow();
    }
}
