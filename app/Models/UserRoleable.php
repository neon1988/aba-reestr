<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class UserRoleable extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'roleable_id',
        'roleable_type',
    ];

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
