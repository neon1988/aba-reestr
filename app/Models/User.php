<?php

namespace App\Models;

use App\Enums\SubscriptionLevelEnum;
use Carbon\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\hasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;
use Opcodes\LogViewer\Facades\Cache;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens, Searchable;

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
        'middlename',
        'subscription_level',
        'subscription_ends_at',
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

    protected $casts = [
        'id' => 'integer',
    ];

    public function toSearchableArray()
    {
        $array = $this->toArray();

        $array['subscription_level'] = SubscriptionLevelEnum::getDescription($array['subscription_level']);

        $keysToRemove = ['password', 'subscription_ends_at', 'email_verified_at'];

        foreach ($keysToRemove as $key)
            unset($array[$key]);

        return $array;
    }

    public function createdSpecialists(): HasMany
    {
        return $this->hasMany(Specialist::class, 'create_user_id');
    }

    public function createdCenters(): HasMany
    {
        return $this->hasMany(Center::class, 'create_user_id');
    }

    public function createdWorksheets(): HasMany
    {
        return $this->hasMany(Worksheet::class, 'create_user_id');
    }

    public function createdWebinars(): HasMany
    {
        return $this->hasMany(Webinar::class, 'create_user_id');
    }

    public function createdConferences(): HasMany
    {
        return $this->hasMany(Conference::class, 'create_user_id');
    }

    public function files(): BelongsToMany
    {
        return $this->belongsToMany(File::class, 'file_user');
    }

    // Связь с созданными специалистами

    /**
     * Связь с фотографией центра.
     */
    public function photo(): hasOne
    {
        return $this->hasOne(File::class, 'id', 'photo_id');
    }

    // Связь с созданными центрами

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

    public function purchasedSubscriptions(): HasMany
    {
        return $this->hasMany(PurchasedSubscription::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function webinars(): BelongsToMany
    {
        return $this->belongsToMany(Webinar::class, 'webinar_subscriptions')
            ->withTimestamps();
    }

    public function updateWebinarsCount()
    {
        $this->webinars_count = $this->webinarSubscriptions()->count();
        $this->save();
    }

    public function webinarSubscriptions(): HasMany
    {
        return $this->hasMany(WebinarSubscription::class);
    }

    public function isSubscriptionActive(): bool
    {
        if ($this->subscription_level == SubscriptionLevelEnum::Free)
            return False;

        return $this->subscription_ends_at && $this->subscription_ends_at->isFuture();
    }

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
            'subscription_ends_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Псевдоатрибут для получения полного ФИО.
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => trim(($attributes['name'] ?? '') . ' ' . ($attributes['lastname'] ?? '') . ' ' . ($attributes['middlename'] ?? '')),
        );
    }

    protected function nameInitials(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => trim(mb_substr($attributes['name'], 0, 1) . mb_substr($attributes['lastname'], 0, 1)),
        );
    }

    public function setLastVerificationEmailSentTime(Carbon $time): void
    {
        Cache::tags('user')->put('last_verification_email_sent_time', $time);
    }

    public function getLastVerificationEmailSentTimestamp() :int
    {
        $time = Cache::tags('user')->get('last_verification_email_sent_time');
        if ($time instanceof \Carbon\Carbon)
            return $time->getTimestamp();
        else
            return 0;
    }

    public function scopeActiveSubscription($query)
    {
        return $query->where(function ($query) {
            $query->where('subscription_ends_at', '>=', Carbon::now())
                ->orWhereNull('subscription_ends_at');
        });
    }
}
