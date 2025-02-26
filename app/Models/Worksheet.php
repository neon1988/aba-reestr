<?php

namespace App\Models;

use App\Observers\WorksheetObserver;
use App\Traits\UserCreated;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

#[ObservedBy([WorksheetObserver::class])]
class Worksheet extends Model
{
    use HasFactory, SoftDeletes, UserCreated, Searchable;

    // Поля, которые могут быть массово назначены
    protected $fillable = [
        'title',
        'description',
        'price',
    ];

    // Указываем поля для работы с датами
    protected $dates = ['deleted_at'];

    public function toSearchableArray()
    {
        $array = $this->toArray();
        $array['extension'] = $this->file ? $this->file->extension : null;
        return $array;
    }

    // Отношение к файлу обложки (например, для изображения)
    public function cover()
    {
        return $this->belongsTo(File::class, 'cover_id')->withDefault();
    }

    // Отношение к файлу материала
    public function file()
    {
        return $this->belongsTo(File::class, 'file_id')->withDefault();
    }

    public function isPaid(): bool
    {
        return (float) $this->price > 0;
    }

    public function isVideo(): bool
    {
        return $this->file?->isVideo() ?? false;
    }
}
