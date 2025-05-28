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

    protected function casts(): array
    {
        return [
            'price' => 'float'
        ];
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();
        $array['extension'] = $this->file ? $this->file->extension : null;
        $array['tags'] = $this->tags ? $this->tags->pluck('name')->toArray() : null;
        return $array;
    }

    // Отношение к файлу обложки (например, для изображения)
    public function cover()
    {
        return $this->belongsTo(File::class, 'cover_id');
    }

    // Отношение к файлу материала
    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'worksheet_tag');
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
