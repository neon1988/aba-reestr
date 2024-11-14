<?php

namespace App\Models;

use App\Traits\CheckedItems;
use App\Traits\UserCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Center extends Model
{
    use SoftDeletes, HasFactory, UserCreated, CheckedItems;

    /**
     * Атрибуты, которые можно заполнять.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'legal_name',
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

    public function scopeActive($query)
    {
        return $query->accepted();
    }

    /**
     * Установить аттрибут для номера телефона, удаляя все лишние символы
     *
     * @param string $value
     * @return void
     */
    public function setPhoneAttribute($value)
    {
        // Убираем все ненужные символы (например, пробелы, скобки, дефисы и т. д.)
        $cleanPhone = preg_replace('/\D/', '', $value);

        // Устанавливаем очищенный номер телефона
        $this->attributes['phone'] = $cleanPhone;
    }
}
