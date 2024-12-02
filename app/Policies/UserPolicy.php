<?php

namespace App\Policies;

use App\Models\Specialist;
use App\Models\User;

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
    public function update(User $authUser, User $user): bool
    {
        return $authUser->id == $user->id;
    }
}
