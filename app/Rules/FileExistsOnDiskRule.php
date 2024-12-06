<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Storage;

class FileExistsOnDiskRule implements ValidationRule
{
    protected $disk;

    public function __construct($disk = null)
    {
        $this->disk = $disk ?? config('filesystems.default');
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = str($value);
        if (!Storage::disk($this->disk)->exists($value)) {
            $fail('Файл не найден '.$value.'');
        }
    }
}
