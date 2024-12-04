<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Связь с созданными специалистами
    public function createdSpecialists()
    {
        return $this->hasMany(Specialist::class, 'create_user_id');
    }

    // Связь с созданными центрами
    public function createdCenters()
    {
        return $this->hasMany(Center::class, 'create_user_id');
    }

    public function files()
    {
        return $this->belongsToMany(File::class, 'file_user');
    }

    /**
     * Связь с фотографией центра.
     */
    public function photo(): \Illuminate\Database\Eloquent\Relations\hasOne
    {
        return $this->hasOne(Image::class, 'id', 'photo_id');
    }

    public function roles()
    {
        return $this->hasMany(UserRoleable::class, 'user_id');
    }

    public function centers()
    {
        return $this->morphedByMany(Center::class, 'roleable', 'user_roleables', 'user_id', 'roleable_id');
    }

    public function specialists()
    {
        return $this->morphedByMany(Specialist::class, 'roleable', 'user_roleables', 'user_id', 'roleable_id');
    }

    public function staffs()
    {
        return $this->morphedByMany(Staff::class, 'roleable', 'user_roleables', 'user_id', 'roleable_id');
    }

    public function hasSpecialistOrCenter(): bool
    {
        return $this->roles->whereIn('roleable_type', [Center::class, Specialist::class])->count() > 0;
    }

    public function isSpecialist(): bool
    {
        return $this->roles->whereIn('roleable_type', Specialist::class)->count() > 0;
    }

    public function isCenter(): bool
    {
        return $this->roles->whereIn('roleable_type', Center::class)->count() > 0;
    }

    public function getCenterId(): int
    {
        return $this->roles->whereIn('roleable_type', Center::class)->first()['roleable_id'];
    }

    public function getSpecialistId(): int
    {
        return $this->roles->whereIn('roleable_type', Specialist::class)->first()['roleable_id'];
    }

    public function isStaff(): bool
    {
        return $this->roles->whereIn('roleable_type', Staff::class)->count() > 0;
    }
}
