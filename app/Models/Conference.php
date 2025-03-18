<?php

namespace App\Models;

use App\Observers\ConferenceObserver;
use App\Traits\UserCreated;
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
        return $query->where('start_at', '>', now());
    }

    /**
     * Скоуп для завершённых мероприятий.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeEnded(Builder $query): Builder
    {
        return $query->where('end_at', '<', now());
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
        return $this->hasOne(File::class, 'id', 'file_id')->withDefault();
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
}
