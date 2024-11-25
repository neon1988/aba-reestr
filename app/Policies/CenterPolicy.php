<?php

namespace App\Policies;

use App\Models\Center;
use App\Models\Specialist;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CenterPolicy extends Policy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Center $center): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Center $center): bool
    {
        if ($user->isCenter())
        {
            return $center->id == $user->getCenterId();
        }

        return False;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Center $center): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Center $center): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Center $center): bool
    {
        //
    }

    public function approve(User $user, Center $center): Response
    {
        return Response::allow();
    }

    public function reject(User $user, Center $center): Response
    {
        return Response::allow();
    }
}
