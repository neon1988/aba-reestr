<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class UserRoleable extends Model
{
    protected $fillable = [
        'user_id',
        'roleable_id',
        'roleable_type',
    ];

    public $timestamps = true;

    /**
     * Связь с пользователем.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Полиморфная связь с ролями.
     */
    public function roleable(): MorphTo
    {
        return $this->morphTo();
    }
}
