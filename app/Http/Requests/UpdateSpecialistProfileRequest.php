<?php

namespace App\Http\Requests;

use App\Enums\EducationEnum;
use App\Rules\FileExistsOnDiskRule;
use App\Rules\PhoneRule;
use App\Rules\TelegramUsername;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSpecialistProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'photo' => [
                'required',
                new FileExistsOnDiskRule()
            ],
            'name' => [
                'required',
                'string',
                'max:50',
            ],
            'lastname' => [
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
            ]
        ];

    }

    public function attributes(): array
    {
        return __('specialist');
    }
}
