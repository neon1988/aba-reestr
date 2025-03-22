<?php

namespace App\Models;

use App\Enums\CurrencyEnum;
use App\Enums\PaymentStatusEnum;
use Database\Factories\PaymentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Payment extends Model
{
    /** @use HasFactory<PaymentFactory> */
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

    public function setCurrencyAttribute($value): void
    {
        if ($value instanceof CurrencyEnum)
            $this->attributes['currency'] = $value;
        else
        {
            if (CurrencyEnum::hasValue($value))
                $this->attributes['currency'] = $value;
            else
            {
                if ($value == 'SBPPSR')
                    $value = 'RUB';

                $this->attributes['currency'] = CurrencyEnum::fromKey(mb_strtoupper($value));
            }
        }
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }
}
