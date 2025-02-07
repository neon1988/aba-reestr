<?php

namespace App\Policies;

use App\Models\Center;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CenterPolicy extends Policy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return Response::deny(__('You do not have permission to create center.'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Center $center): Response
    {
        if ($user->isCenter()) {
            return $center->id == $user->getCenterId()
                ? Response::allow()
                : Response::deny(__('You do not have permission to update this center.'));
        }

        return Response::deny(__('You do not have permission to update this center.'));
    }

    /**
     * Determine whether the user can approve the model.
     */
    public function approve(User $user, Center $center): Response
    {
        return Response::deny(__('You do not have permission to approve this center.'));
    }

    /**
     * Determine whether the user can reject the model.
     */
    public function reject(User $user, Center $center): Response
    {
        return Response::deny(__('You do not have permission to reject this center.'));
    }
}
