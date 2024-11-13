<?php

namespace App\Models;

use App\Traits\UserCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Specialist extends Model
{
    use SoftDeletes, HasFactory, UserCreated;

    protected $fillable = [
        'lastname',
        'firstname',
        'middlename',
        'country',
        'region',
        'city',
        'education',
        'phone'
    ];

    /**
     * Связь "один ко многим (обратная)" с моделью Center
     */
    public function center()
    {
        return $this->belongsTo(Center::class);
    }

    /**
     * Связь "один к одному" с моделью File (для фото специалиста)
     */
    public function photo(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Image::class, 'id', 'photo_id');
    }


}
