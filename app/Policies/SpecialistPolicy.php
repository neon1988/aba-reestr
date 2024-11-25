<?php

namespace App\Policies;

use App\Models\Specialist;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SpecialistPolicy extends Policy
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
    public function view(User $user, Specialist $specialist): bool
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
    public function update(User $user, Specialist $specialist): bool
    {
        if ($user->isSpecialist())
        {
            return $specialist->id == $user->getSpecialistId();
        }
        return False;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Specialist $specialist): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Specialist $specialist): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Specialist $specialist): bool
    {
        //
    }

    public function approve(User $user, Specialist $specialist): Response
    {
        return Response::allow();
    }

    public function reject(User $user, Specialist $specialist): Response
    {
        return Response::allow();
    }
}
