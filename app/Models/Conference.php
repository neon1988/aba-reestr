<?php

namespace App\Models;

use Database\Factories\ConferenceFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    /** @use HasFactory<ConferenceFactory> */
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
}
