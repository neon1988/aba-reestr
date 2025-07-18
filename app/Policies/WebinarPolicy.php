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
    public function view(User $authUser, Webinar $webinar): Response
    {
        if ($authUser->isStaff())
            return Response::allow();
        return $this->checkPaidAccess($authUser, $webinar);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $authUser): Response
    {
        if ($authUser->isStaff())
            return Response::allow();
        return Response::deny(__('You are not allowed to create a webinar.'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $authUser, Webinar $webinar): Response
    {
        if ($authUser->isStaff())
            return Response::allow();
        return Response::deny(__('You are not allowed to update this webinar.'));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $authUser, Webinar $webinar): Response
    {
        if ($authUser->isStaff())
            return Response::allow();
        return Response::deny(__('You are not allowed to delete this webinar.'));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function subscribe(User $authUser, Webinar $webinar): Response
    {
        if ($authUser->isStaff())
            return Response::allow();

        return $this->checkPaidAccess($authUser, $webinar);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function unsubscribe(User $authUser, Webinar $webinar): Response
    {
        if ($authUser->isStaff())
            return Response::allow();
        return $this->checkPaidAccess($authUser, $webinar);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function toggleSubscription(User $authUser, Webinar $webinar): Response
    {
        if ($webinar->isEnded())
            return Response::deny(__("Webinar is ended"));

        if ($authUser->isStaff())
            return Response::allow();

        return $this->checkPaidAccess($authUser, $webinar);
    }

    /**
     * Determine whether the user can watch the webinar.
     */
    public function watch(User $authUser, Webinar $webinar): Response
    {
        if (!$webinar->hasRecordFile())
            return Response::deny(__("The webinar has no record."));

        if (!$webinar->isVideo())
            return Response::deny(__("You can only watch it if the file is a video file."));

        if ($authUser->isStaff())
            return Response::allow();

        return $this->checkPaidAccess($authUser, $webinar);
    }

    /**
     * Determine whether the user can download the webinar.
     */
    public function download(User $authUser, Webinar $webinar): Response
    {
        if ($authUser->isStaff())
            return Response::allow();

        return $this->checkPaidAccess($authUser, $webinar);
    }

    /**
     * Determine whether the user can buy the webinar.
     */
    public function buy(?User $authUser, Webinar $webinar): Response
    {
        if (!$webinar->isPaid())
            return Response::deny(__("The webinar is not paid."));

        if ($authUser->isStaff())
            return Response::deny();

        if ($authUser->isSubscriptionActive())
            return Response::deny(__("You can't buy it because you already have a subscription"));

        if ($webinar->isPurchasedByUser($authUser))
            return Response::deny(__("You have already bought this product."));

        return Response::allow();
    }

    /**
     * Общая логика проверки для платного контента
     */
    private function checkPaidAccess(User $user, Webinar $webinar): Response
    {
        if (!$webinar->isPaid())
            return Response::allow();

        if ($webinar->isPurchasedByUser($user))
            return Response::allow();

        if (!$user->isSubscriptionActive())
            return Response::deny(__("You don't have a subscription or your subscription is inactive."));

        return Response::allow();
    }
}
