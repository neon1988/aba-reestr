<?php

namespace App\Models;

use App\Observers\CenterObserver;
use App\Traits\CheckedItems;
use App\Traits\UserCreated;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use InvalidArgumentException;
use Laravel\Scout\Searchable;

#[ObservedBy([CenterObserver::class])]
class Center extends Model
{
    use SoftDeletes, HasFactory, UserCreated, CheckedItems, Searchable;

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
        'ogrn',
        'legal_address',
        'actual_address',
        'profile_address_1',
        'profile_address_2',
        'profile_address_3',
        'account_number',
        'bik',
        'director_position',
        'director_name',
        'acting_on_basis',
        'profile_phone',
        'profile_email',
        'services',
        'intensives',
    ];

    public function toSearchableArray()
    {
        $array = $this->toArray();

        $keysToRemove = ['id', 'photo_id', 'create_user_id',
            'status_changed_at', 'status_changed_user_id', 'created_at', 'updated_at', 'deleted_at'];

        foreach ($keysToRemove as $key)
            unset($array[$key]);

        return $array;
    }

    /**
     * Связь с фотографией центра.
     */
    public function photo(): \Illuminate\Database\Eloquent\Relations\hasOne
    {
        return $this->hasOne(File::class, 'id', 'photo_id');
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
        // Проверяем, начинается ли значение с "+"
        if (!str_starts_with($value, '+')) {
            throw new InvalidArgumentException('Phone number must start with a "+" symbol.');
        }

        // Оставляем "+" в начале, а затем удаляем все остальные нецифровые символы
        $cleanPhone = preg_replace('/(?!^\+)[^\d]/', '', $value);

        // Устанавливаем очищенный номер телефона
        $this->attributes['phone'] = $cleanPhone;
    }


    public function files()
    {
        return $this->belongsToMany(File::class, 'center_file');
    }

    /**
     * Полиморфная связь с пользователями.
     */
    public function user(): morphOne
    {
        return $this->morphOne(User::class, 'roleable', 'user_roleables', 'roleable_id', 'user_id');
    }
}
