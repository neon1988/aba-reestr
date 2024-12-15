<?php

namespace App\Models;

use App\Traits\UserCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Worksheet extends Model
{
    use HasFactory, SoftDeletes, UserCreated;

    // Поля, которые могут быть массово назначены
    protected $fillable = [
        'title',
        'description',
        'create_user_id',
        'type',
        'cover_id',
        'file_id'
    ];

    // Указываем поля для работы с датами
    protected $dates = ['deleted_at'];

    // Отношение к файлу обложки (например, для изображения)
    public function cover()
    {
        return $this->belongsTo(Image::class, 'cover_id');
    }

    // Отношение к файлу материала
    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }
}
