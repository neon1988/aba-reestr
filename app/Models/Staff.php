<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'settings_access',
    ];

    public $timestamps = true;

    /**
     * Полиморфная связь с пользователями.
     */
    public function users(): MorphToMany
    {
        return $this->morphToMany(User::class, 'roleable', 'roleables', 'roleable_id', 'user_id');
    }
}
