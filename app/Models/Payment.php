<?php

namespace App\Models;

use App\Enums\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'payment_provider',
        'user_id',
        'amount',
        'currency',
        'status',
        'payment_method',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function setStatusAttribute($value): void
    {
        if ($value instanceof PaymentStatusEnum)
            $this->attributes['status'] = $value;
        else
            $this->attributes['status'] = PaymentStatusEnum::fromKey(mb_strtoupper($value));
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
