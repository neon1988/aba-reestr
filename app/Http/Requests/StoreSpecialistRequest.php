<?php

namespace App\Http\Requests;

use App\Enums\EducationEnum;
use App\Rules\FileExistsOnDiskRule;
use App\Rules\PhoneRule;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class StoreSpecialistRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
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
                new PhoneRule(),
            ],
            'files' => [
                'required',
                new FileExistsOnDiskRule()
            ],
            'additional_courses' => [
                'nullable',
                new FileExistsOnDiskRule()
            ],
        ];

        // Условное правило для фото
        if (!$this->user()->photo) { // Проверяем, есть ли у пользователя фото
            $rules['photo'] = [
                'required',
                new FileExistsOnDiskRule()
            ];
        }
        return $rules;
    }

    public function attributes(): array
    {
        return __('specialist');
    }

    public function messages()
    {
        return [

            'lastname.required' => 'Фамилия является обязательным полем.',
            'lastname.string' => 'Фамилия должна быть строкой.',
            'lastname.max' => 'Фамилия не может превышать 50 символов.',

            'name.required' => 'Имя является обязательным полем.',
            'name.string' => 'Имя должно быть строкой.',
            'name.max' => 'Имя не может превышать 50 символов.',

            'middlename.string' => 'Отчество должно быть строкой.',
            'middlename.max' => 'Отчество не может превышать 50 символов.',

            'country.required' => 'Страна является обязательным полем.',
            'country.string' => 'Страна должна быть строкой.',
            'country.max' => 'Страна не может превышать 100 символов.',

            'region.string' => 'Регион должен быть строкой.',
            'region.max' => 'Регион не может превышать 100 символов.',

            'city.required' => 'Город является обязательным полем.',
            'city.string' => 'Город должен быть строкой.',
            'city.max' => 'Город не может превышать 100 символов.',

            'education.required' => 'Образование является обязательным полем.',
            'education.string' => 'Образование должно быть строкой.',
            'education.max' => 'Образование не может превышать 255 символов.',

            'phone.required' => 'Телефон является обязательным полем.',
            'phone.string' => 'Телефон должен быть строкой.',
            'phone.regex' => 'Телефон должен содержать от 10 до 15 цифр и может начинаться с символа "+".',
        ];
    }
}
