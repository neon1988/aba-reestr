<?php

namespace App\Models;

use App\Observers\BulletinObserver;
use App\Traits\CheckedItems;
use App\Traits\UserCreated;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

#[ObservedBy([BulletinObserver::class])]
class Bulletin extends Model
{
    /** @use HasFactory<\Database\Factories\BulletinFactory> */
    use SoftDeletes, HasFactory, UserCreated, CheckedItems, Searchable;

    protected $fillable = [
        'text'
    ];
}
