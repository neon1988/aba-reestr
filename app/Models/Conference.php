<?php

namespace App\Models;

use App\Enums\SubscriptionLevelEnum;
use App\Observers\ConferenceObserver;
use App\Traits\UserCreated;
use Carbon\Carbon;
use Database\Factories\ConferenceFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([ConferenceObserver::class])]
class Conference extends Model
{
    /** @use HasFactory<ConferenceFactory> */
    use HasFactory, SoftDeletes, UserCreated;

    protected $fillable = [
        'title',
        'description',
        'start_at',
        'end_at',
        'registration_url',
        'price',
        'available_for_subscriptions',
        'url_button_text'
    ];

    protected function casts(): array
    {
        return [
            'start_at' => 'datetime',
            'end_at' => 'datetime',
            'deleted_at' => 'datetime',
            'last_notified_at' => 'datetime',
            'available_for_subscriptions' => 'array',
            'url_button_text' => 'string'
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

    public function cover(): hasOne
    {
        return $this->hasOne(File::class, 'id', 'cover_id');
    }

    public function file(): hasOne
    {
        return $this->hasOne(File::class, 'id', 'file_id');
    }

    public function isPaid(): bool
    {
        return (float) $this->price > 0;
    }

    public function hasRecordFile() :bool
    {
        if (!$this->file)
            return false;

        return !$this->file->trashed();
    }

    public function isVideo(): bool
    {
        return $this->file?->isVideo() ?? false;
    }

    public function isEnded(): bool
    {
        if (empty($this->end_at))
            return false;

        return $this->end_at <= now();
    }

    public function shouldNotifyAgain() :bool
    {
        if (empty($this->last_notified_at))
            return true;

        return $this->last_notified_at->lessThan(Carbon::now()->subMinutes(5));
    }

    public function isAvailableForSubscription($number): bool
    {
        $array = (array)$this->available_for_subscriptions;
        $array = array_filter($array, fn($n) => $n !== SubscriptionLevelEnum::Free);

        if (empty($array))
            return true;

        return in_array($number, $array);
    }
}
