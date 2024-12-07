<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Storage;
use Litlife\Url\Url;

class FileExistsOnDiskRule implements ValidationRule
{
    protected $disk;

    public function __construct($disk = null)
    {
        $this->disk = $disk ?? config('filesystems.default');
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Проверка, если $value — это массив
        if (is_array($value)) {
            // Для каждого файла в массиве
            foreach ($value as $file) {
                $this->checkFileExistence($file, $fail);
            }
        } else {
            // Если $value — это одиночный файл
            $this->checkFileExistence($value, $fail);
        }
    }

    // Метод для проверки существования файла на диске
    protected function checkFileExistence(string $file, Closure $fail): void
    {
        $file = str($file); // Преобразуем путь к строке
        if (!Storage::disk($this->disk)->exists($file)) {
            $fail('Файл не найден: ' . Url::fromString($file)->getBasename());
        }
    }
}
