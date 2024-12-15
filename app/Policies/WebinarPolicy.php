<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Webinar;
use Illuminate\Auth\Access\Response;

class WebinarPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Webinar $webinar): bool
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Webinar $webinar): bool
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Webinar $webinar): bool
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Webinar $webinar): bool
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Webinar $webinar): bool
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function subscribe(User $user, Webinar $webinar): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function unsubscribe(User $user, Webinar $webinar): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function toggleSubscription(User $user, Webinar $webinar): Response
    {
        return Response::allow();
    }
}
