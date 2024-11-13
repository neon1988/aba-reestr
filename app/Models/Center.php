<?php

namespace App\Models;

use App\Traits\UserCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Center extends Model
{
    use SoftDeletes, HasFactory, UserCreated;

    /**
     * Атрибуты, которые можно заполнять.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'legal_name',
        'address',
        'legal_address',
        'inn',
        'kpp',
        'country',
        'region',
        'city',
        'phone'
    ];

    /**
     * Связь с фотографией центра.
     */
    public function photo()
    {
        return $this->belongsTo(Image::class);
    }

    /**
     * Связь с файлами центра (дополнительные фотографии и документы).
     */
    public function files()
    {
        return $this->hasMany(File::class);
    }
}
