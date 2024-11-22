<?php

namespace App\Policies;

use App\Models\Specialist;
use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Specialist $specialist): bool
    {
        //
    }
}
