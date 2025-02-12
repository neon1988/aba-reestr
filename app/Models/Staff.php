<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use SoftDeletes, HasFactory;

    public $timestamps = true;
    protected $fillable = [
        'role',
        'settings_access',
        'settings_notifications'
    ];

    /**
     * Полиморфная связь с пользователями.
     */
    public function users(): MorphToMany
    {
        return $this->morphToMany(User::class, 'roleable', 'user_roleables', 'roleable_id', 'user_id');
    }
}
