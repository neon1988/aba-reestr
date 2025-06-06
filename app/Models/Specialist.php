<?php

namespace App\Models;

use App\Enums\EducationEnum;
use App\Observers\SpecialistObserver;
use App\Traits\CheckedItems;
use App\Traits\UserCreated;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use InvalidArgumentException;
use Laravel\Scout\Searchable;
use Litlife\Url\Url;

#[ObservedBy([SpecialistObserver::class])]
class Specialist extends Model
{
    use SoftDeletes, HasFactory, UserCreated, CheckedItems, Searchable;

    protected $fillable = [
        'name',
        'lastname',
        'middlename',
        'country',
        'region',
        'city',
        'education',
        'phone',
        'center_name',
        'curator',
        'supervisor',
        'professional_interests',
        'show_email',
        'show_phone',
        'telegram_profile',
        'vk_profile',
        'aba_education',
        'aba_trainings',
        'professional_specialization',
        'additional_info',
        'has_available_hours',
    ];

    public function toSearchableArray()
    {
        $array = $this->toArray();
        $array['education'] = EducationEnum::getDescription($array['education']);

        $keysToRemove = ['id', 'is_available', 'photo_id', 'create_user_id',
            'status_changed_at', 'status_changed_user_id', 'updated_at', 'deleted_at'];

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
        return $this->belongsToMany(File::class, 'specialist_file');
    }

    public function additional_courses()
    {
        return $this->belongsToMany(File::class, 'specialist_additional_courses');
    }

    public function certificates()
    {
        return $this->belongsToMany(File::class, 'specialist_certificates');
    }

    /**
     * Полиморфная связь с пользователями.
     */
    public function users(): morphToMany
    {
        return $this->morphToMany(User::class, 'roleable', 'user_roleables', 'roleable_id', 'user_id');
    }

    /**
     * Псевдоатрибут для получения полного ФИО.
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => trim(
                implode(' ', array_filter([
                    $attributes['name'] ?? null,
                    $attributes['lastname'] ?? null,
                    $attributes['middlename'] ?? null
                ]))
            ),
        );
    }

    protected function telegramProfile(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => $value ? '@' . trim($value, '@') : null,
            set: fn(?string $value) => $value ? trim($value, '@') : null,
        );
    }

    protected function vkProfile(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => $value ? $value : null,
            set: function (?string $value) {
                $value = trim($value);

                if (filter_var($value, FILTER_VALIDATE_URL)) {
                    $url = Url::fromString($value);

                    if (preg_match('/(^|\.)vk\.com$/i', $url->getHost())) {
                        return trim($url->getPath(), '/');
                    }

                } else {
                    $value = trim($value, '@');

                    if (empty($value))
                        return null;
                }

                return $value;
            }
        );
    }

    protected function telegramUrl(): Attribute
    {
        return Attribute::make(
            get: function(mixed $value, array $attributes) {
                return 'https://t.me/'. trim($attributes['telegram_profile'], '@');
            },
        );
    }

    protected function vkUrl(): Attribute
    {
        return Attribute::make(
            get: function(mixed $value, array $attributes) {
                return 'https://vk.com/'. trim($attributes['vk_profile'], '@');
            },
        );
    }
}
