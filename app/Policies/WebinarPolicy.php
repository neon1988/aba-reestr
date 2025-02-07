<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Webinar;
use Illuminate\Auth\Access\Response;

class WebinarPolicy extends Policy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Webinar $webinar): Response
    {
        if ($user->isSubscriptionActive())
            return Response::allow(__('You are allowed to view this webinar.'));

        return Response::deny(__('You need an active subscription to view this webinar.'));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return Response::deny(__('You are not allowed to create a webinar.'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Webinar $webinar): Response
    {
        return Response::deny(__('You are not allowed to update this webinar.'));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Webinar $webinar): Response
    {
        return Response::deny(__('You are not allowed to delete this webinar.'));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function subscribe(User $user, Webinar $webinar): Response
    {
        if ($user->isSubscriptionActive())
            return Response::allow(__('You are allowed to subscribe to this webinar.'));

        return Response::deny(__('You need an active subscription to subscribe to this webinar.'));
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function unsubscribe(User $user, Webinar $webinar): Response
    {
        if ($user->isSubscriptionActive())
            return Response::allow(__('You are allowed to unsubscribe from this webinar.'));

        return Response::deny(__('You need an active subscription to unsubscribe from this webinar.'));
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function toggleSubscription(User $user, Webinar $webinar): Response
    {
        if ($user->isSubscriptionActive())
            return Response::allow(__('You are allowed to toggle subscription for this webinar.'));

        return Response::deny(__('You need an active subscription to toggle your subscription.'));
    }
}
