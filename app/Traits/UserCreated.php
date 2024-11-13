<?php

namespace App\Traits;

use App\Models\User;

trait UserCreated
{
    public function creator()
    {
        return $this->belongsTo(User::class, 'create_user_id');
    }
}
