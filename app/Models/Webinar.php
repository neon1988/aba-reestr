<?php

namespace App\Models;

use App\Observers\WebinarObserver;
use App\Traits\UserCreated;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([WebinarObserver::class])]
class Webinar extends Model
{
    /** @use HasFactory<\Database\Factories\WebinarFactory> */
    use HasFactory, UserCreated, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'start_at',
        'end_at',
        'stream_url',
        'price'
    ];

    protected function casts(): array
    {
        return [
            'start_at' => 'datetime',
            'end_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Скоуп для предстоящих мероприятий.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where(function (Builder $query) {
            return $query->where('end_at', '>', now())
                ->orWhereNull('end_at');
        });
    }

    /**
     * Скоуп для завершённых мероприятий.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeEnded(Builder $query): Builder
    {
        return $query->where('end_at', '<=', now());
    }

    /**
     * Скоуп для текущих мероприятий.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeOngoing(Builder $query): Builder
    {
        return $query->where('start_at', '<=', now())
            ->where('end_at', '>=', now());
    }

    public function cover(): \Illuminate\Database\Eloquent\Relations\hasOne
    {
        return $this->hasOne(File::class, 'id', 'cover_id');
    }

    public function record_file(): \Illuminate\Database\Eloquent\Relations\hasOne
    {
        return $this->hasOne(File::class, 'id', 'record_file_id');
    }

    public function hasRecordFile() :bool
    {
        if (!$this->record_file)
            return false;

        return !$this->record_file->trashed();
    }

    public function isVideo(): bool
    {
        return $this->record_file?->isVideo() ?? false;
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(WebinarSubscription::class);
    }

    public function updateSubscribersCount()
    {
        $this->subscribers_count = $this->subscribers()->count(); // Получаем количество пользователей, подписанных на этот вебинар
        $this->save(); // Сохраняем обновленное значение в базе
    }

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'webinar_subscriptions')->withTimestamps();
    }

    public function isPaid(): bool
    {
        return (float) $this->price > 0;
    }

    public function isEnded(): bool
    {
        if (empty($this->end_at))
            return false;

        return $this->end_at <= now();
    }
}
