<?php

namespace App\Http\Requests;

use App\Rules\PhoneRule;
use App\Rules\TelegramUsername;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UpdateSpecialistRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'photo' => [
                'nullable',
                File::image()
                    ->types(config('upload.support_images_formats'))
                    ->min(config('upload.image_min_size'))
                    ->max(config('upload.image_max_size'))
            ],
            'lastname' => [
                'required',
                'string',
                'max:50',
            ],
            'name' => [
                'required',
                'string',
                'max:50',
            ],
            'middlename' => [
                'nullable',
                'string',
                'max:50',
            ],
            'phone' => [
                'required',
                'string',
                new PhoneRule(10, 15), // Используем кастомное правило Phone
            ],
            'show_email' => [
                'required',
                'boolean'
            ],
            'show_phone' => [
                'required',
                'boolean'
            ],
            'telegram_profile' => [
                'nullable',
                new TelegramUsername()
            ],
        ];

    }

    public function attributes(): array
    {
        return __('specialist');
    }
}
