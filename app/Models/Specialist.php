<?php

namespace App\Models;

use App\Traits\CheckedItems;
use App\Traits\UserCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Specialist extends Model
{
    use SoftDeletes, HasFactory, UserCreated, CheckedItems, Searchable;

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

    public function toSearchableArray()
    {
        $array = $this->toArray();

        $keysToRemove = ['id', 'is_available', 'photo_id', 'create_user_id',
            'status_changed_at', 'status_changed_user_id', 'created_at', 'updated_at', 'deleted_at'];

        foreach ($keysToRemove as $key)
            unset($array[$key]);

        return $array;
    }

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
    public function photo(): \Illuminate\Database\Eloquent\Relations\hasOne
    {
        return $this->hasOne(Image::class, 'id', 'photo_id');
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

    public function files()
    {
        return $this->belongsToMany(File::class, 'specialist_file');
    }
}
