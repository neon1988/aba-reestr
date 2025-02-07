<?php

namespace App\Http\Requests;

use App\Enums\EducationEnum;
use App\Rules\FileExistsOnDiskRule;
use App\Rules\PhoneRule;
use App\Rules\TelegramUsername;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSpecialistRequest extends FormRequest
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
                'nullable',
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
            'country' => [
                'required',
                'string',
                'max:100',
                'exists:App\Models\Country,name',
            ],
            'region' => [
                'nullable',
                'string',
                'max:100',
            ],
            'city' => [
                'required',
                'string',
                'max:100',
            ],
            'education' => [
                'required',
                new EnumValue(EducationEnum::class, false)
            ],
            'phone' => [
                'required',
                'string',
                new PhoneRule(10, 15), // Используем кастомное правило Phone
            ],
            'center_name' => [
                'nullable',
                'string',
                'max:200',
            ],
            'curator' => [
                'nullable',
                'string',
                'max:200',
            ],
            'supervisor' => [
                'nullable',
                'string',
                'max:200',
            ],
            'professional_interests' => [
                'nullable',
                'string',
                'max:200',
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
            'files' => [
                'required',
                'array',
                new FileExistsOnDiskRule()
            ],
            'additional_courses' => [
                'nullable',
                new FileExistsOnDiskRule()
            ],
        ];

    }

    public function attributes(): array
    {
        return __('specialist');
    }
}
