<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class FilePolicy extends Policy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return Response::allow();
    }
}
