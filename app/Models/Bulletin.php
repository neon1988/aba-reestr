<?php

namespace App\Models;

use App\Traits\CheckedItems;
use App\Traits\UserCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Bulletin extends Model
{
    /** @use HasFactory<\Database\Factories\BulletinFactory> */
    use SoftDeletes, HasFactory, UserCreated, CheckedItems, Searchable;

    protected $fillable = [
        'text'
    ];



}
