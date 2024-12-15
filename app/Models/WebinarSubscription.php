<?php

namespace App\Models;

use App\Observers\WebinarSubscriptionObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([WebinarSubscriptionObserver::class])]
class WebinarSubscription extends Model
{
    /** @use HasFactory<\Database\Factories\WebinarSubscriptionFactory> */
    use HasFactory;

    // Указываем поля, которые можно массово присваивать
    protected $fillable = [
        'user_id',
        'webinar_id',
        'subscribed_at',
    ];

    // Взаимосвязь с моделью User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Взаимосвязь с моделью Webinar
    public function webinar()
    {
        return $this->belongsTo(Webinar::class);
    }
}
