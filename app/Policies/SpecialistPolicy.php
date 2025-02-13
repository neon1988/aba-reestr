<?php

namespace App\Policies;

use App\Models\Specialist;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SpecialistPolicy extends Policy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Specialist $specialist): Response
    {
        if ($user->isStaff())
            return Response::allow();
        if ($user->isSpecialist()) {
            return $specialist->id == $user->getSpecialistId()
                ? Response::allow()
                : Response::deny(__('You do not have permission to update this specialist.'));
        }
        return Response::deny(__('You do not have permission to update this specialist.'));
    }

    public function approve(User $user, Specialist $specialist): Response
    {
        if ($user->isStaff())
            return Response::allow();
        return Response::deny(__('You do not have permission to approve this specialist.'));
    }

    public function reject(User $user, Specialist $specialist): Response
    {
        if ($user->isStaff())
            return Response::allow();
        return Response::deny(__('You do not have permission to reject this specialist.'));
    }
}
