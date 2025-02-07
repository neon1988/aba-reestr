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
        if (is_array($value) and !array_key_exists('path', $value)) {
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
    protected function checkFileExistence(mixed $file, Closure $fail): void
    {
        if (is_array($file)) {
            if (!array_key_exists('path', $file) or !array_key_exists('storage', $file)) {
                $fail('Файл не найден');
                return;
            }
        }

        if (!Storage::disk($file['storage'])->exists($file['path'])) {
            $fail('Файл не найден: ' . Url::fromString($file['path'])->getBasename());
        }
    }
}
