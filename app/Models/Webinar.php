<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Webinar extends Model
{
    /** @use HasFactory<\Database\Factories\WebinarFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_at',
        'end_at',
        'cover'
    ];

    protected function casts(): array
    {
        return [
            'start_at' => 'date',
            'end_at' => 'date',
        ];
    }

    /**
     * Скоуп для предстоящих мероприятий.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('start_at', '>', now());
    }

    /**
     * Скоуп для завершённых мероприятий.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeEnded(Builder $query): Builder
    {
        return $query->where('end_at', '<', now());
    }

    /**
     * Скоуп для текущих мероприятий.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeOngoing(Builder $query): Builder
    {
        return $query->where('start_at', '<=', now())
            ->where('end_at', '>=', now());
    }

    public function cover(): \Illuminate\Database\Eloquent\Relations\hasOne
    {
        return $this->hasOne(Image::class, 'id', 'cover_id');
    }

    public function record_file(): \Illuminate\Database\Eloquent\Relations\hasOne
    {
        return $this->hasOne(File::class, 'id', 'record_file_id');
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(WebinarSubscription::class);
    }

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'webinar_subscriptions')->withTimestamps();
    }

    public function updateSubscribersCount()
    {
        $this->subscribers_count = $this->subscribers()->count(); // Получаем количество пользователей, подписанных на этот вебинар
        $this->save(); // Сохраняем обновленное значение в базе
    }
}
