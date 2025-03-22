<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    /** @use HasFactory<\Database\Factories\PurchaseFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'payment_id',
        'purchasable_id',
        'purchasable_type',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function purchasable(): MorphTo
    {
        return $this->morphTo();
    }
}
