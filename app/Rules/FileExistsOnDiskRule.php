<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Storage;
use Litlife\Url\Url;

class FileExistsOnDiskRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Проверка, если $value — это массив
        if (is_array($value) and !array_key_exists('path', $value) and !array_key_exists('storage', $value)) {
            // Для каждого файла в массиве
            foreach ($value as $file) {
                $this->checkSingleFile($file, $fail);
            }
        } else {
            // Если $value — это одиночный файл
            $this->checkSingleFile($value, $fail);
        }
    }

    // Метод для проверки существования файла на диске
    protected function checkSingleFile(mixed $file, Closure &$fail): void
    {
        $file = (array)($file);
        if (array_key_exists('storage', $file) and array_key_exists('path', $file)) {
            if (!Storage::disk($file['storage'])->exists($file['path'])) {
                $fail('Файл не найден');
            }
            return;
        }

        $fail('Ошибка загрузки файла');
    }
}
