<?php

namespace App\Policies;

use App\Models\Bulletin;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BulletinPolicy extends Policy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Bulletin $bulletin): Response
    {
        if (!$bulletin->isCreator($user))
            return Response::deny(__('You are not the creator of this bulletin.'));

        return Response::allow();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Bulletin $bulletin): Response
    {
        if (!$bulletin->isCreator($user))
            return Response::deny(__('You are not the creator of this bulletin.'));

        return Response::allow();
    }

    /**
     * Determine whether the user can approve the model.
     */
    public function approve(User $user, Bulletin $bulletin): Response
    {
        return Response::deny(__('You do not have permission to approve this bulletin.'));
    }

    /**
     * Determine whether the user can reject the model.
     */
    public function reject(User $user, Bulletin $bulletin): Response
    {
        return Response::deny(__('You do not have permission to reject this bulletin.'));
    }
}
