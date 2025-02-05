<?php

namespace App\Policies;

use App\Enums\SubscriptionLevelEnum;
use App\Models\Specialist;
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

    public function viewLogViewer(?User $user): bool
    {
        return True;
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
        return Response::allow();
    }

    public function updateSubscription(User $authUser): Response
    {
        return Response::deny();
    }

    public function createSpecialist(User $authUser): Response
    {
        if (!$authUser->isSubscriptionActive())
            return Response::deny(__('Подписка не активна'));

        if ($authUser->subscription_level != SubscriptionLevelEnum::Specialists)
            return Response::deny(__('Подписка не для специалиста'));

        if ($authUser->isSpecialist())
            return Response::deny(__('Страница специалиста уже добавлена'));

        return Response::allow();
    }
}
