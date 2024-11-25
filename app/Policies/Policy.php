<?php

namespace App\Policies;

use App\Models\User;

class Policy
{
    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isStaff()) {
            return true;
        }

        return null;
    }
}
