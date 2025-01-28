<?php

namespace App\Http\Requests;

use App\Enums\EducationEnum;
use App\Rules\FileExistsOnDiskRule;
use App\Rules\PhoneRule;
use App\Rules\TelegramUsername;
use App\Rules\VkUsername;
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
            ],
            'vk_profile' => [
                'nullable',
                new VkUsername()
            ],
            'aba_education' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'aba_trainings' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'professional_specialization' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'additional_info' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'has_available_hours' => [
                'required',
                'boolean'
            ],
        ];

    }

    public function attributes(): array
    {
        return __('specialist');
    }
}
