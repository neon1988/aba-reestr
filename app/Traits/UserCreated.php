<?php

namespace App\Traits;

use App\Models\User;

trait UserCreated
{
    public function creator()
    {
        return $this->belongsTo(User::class, 'create_user_id');
    }

    public function isCreator(User $user): bool
    {
        return $this->create_user_id === $user->id;
    }
}
