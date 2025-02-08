<?php

namespace App\Policies;

use App\Enums\SubscriptionLevelEnum;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy extends Policy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function purchaseSubscription(User $authUser): Response
    {
        if ($authUser->isSubscriptionActive())
            return Response::deny(__("You already have an active subscription"));

        return Response::allow();
    }

    public function viewLogViewer(?User $user): Response
    {
        return Response::allow(__('You have permission to view the log viewer.'));
        /*
        return $request->user()
            && in_array($request->user()->email, [
                'stepan.entsov@gmail.com',
            ]);
        */
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $authUser, User $user): Response
    {
        if ($authUser->is($user))
            return Response::allow(__('You can update your own profile.'));
        return Response::deny(__('You are not authorized to update this profile.'));
    }

    public function createSpecialist(User $authUser): Response
    {
        if (!$authUser->isSubscriptionActive())
            return Response::deny(__("You don't have a subscription or your subscription is inactive."));

        if ($authUser->subscription_level != SubscriptionLevelEnum::Specialists)
            return Response::deny(__('You do not have the required subscription level.'));

        if ($authUser->isSpecialist())
            return Response::deny(__('You are already a specialist.'));

        return Response::allow(__('You can create a new specialist.'));
    }

    public function updateSubscription(User $authUser): Response
    {
        return Response::deny(__('You are not authorized to change users subscription.'));
    }

    /**
     * Determine whether the user can view webinars.
     */
    public function viewWebinars(User $authUser, User $user): Response
    {
        if ($authUser->is($user))
            return Response::allow(__('You can view your own webinars.'));
        return Response::deny(__('You are not authorized to view this user’s webinars.'));
    }

    /**
     * Determine whether the user can view payments.
     */
    public function viewPayments(User $authUser, User $user): Response
    {
        if ($authUser->is($user))
            return Response::allow(__('You can view your own payments.'));
        return Response::deny(__('You are not authorized to view this user’s payments.'));
    }
}
