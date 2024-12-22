<?php

namespace App\Http\Requests;

use App\Enums\StatusEnum;
use App\Rules\FileExistsOnDiskRule;
use App\Rules\InnRule;
use App\Rules\KppRule;
use App\Rules\PhoneRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCenterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'legal_name' => [
                'required',
                'string',
                'max:255',
            ],
            'phone' => [
                'required',
                'string',
                new PhoneRule(),
            ],
            'inn' => [
                'required',
                'string',
                new InnRule(),
                Rule::unique('centers')
                    ->whereNull('deleted_at')
                    ->whereIn('status', [StatusEnum::Accepted, StatusEnum::OnReview])
            ],
            'kpp' => [
                'nullable',
                'string',
                new KppRule(),
                Rule::unique('centers')
                    ->whereNull('deleted_at')
                    ->whereIn('status', [StatusEnum::Accepted, StatusEnum::OnReview])
            ],
            'ogrn' => [
                'required',
                'string',
                'size:13', // ОГРН состоит из 13 символов
            ],
            'legal_address' => [
                'required',
                'string',
                'max:255',
            ],
            'actual_address' => [
                'required',
                'string',
                'max:255',
            ],
            'profile_address_1' => [
                'required',
                'string',
                'max:255',
            ],
            'profile_address_2' => [
                'nullable',
                'string',
                'max:255',
            ],
            'profile_address_3' => [
                'nullable',
                'string',
                'max:255',
            ],
            'account_number' => [
                'required',
                'string',
                'regex:/^\d{20}$/', // Расчетный счет состоит из 20 цифр
            ],
            'bik' => [
                'required',
                'string',
                'regex:/^\d{9}$/', // БИК состоит из 9 цифр
            ],
            'director_position' => [
                'required',
                'string',
                'max:100',
            ],
            'director_name' => [
                'required',
                'string',
                'max:255',
            ],
            'acting_on_basis' => [
                'required',
                'string',
                'max:255',
            ],
            'profile_phone' => [
                'required',
                'string',
                new PhoneRule(),
            ],
            'profile_email' => [
                'required',
                'string',
                'email',
                'max:255',
            ],
            'files' => [
                'required',
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
        return __('center');
    }

    /**
     * Сообщения об ошибках для валидации (опционально).
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Пожалуйста, введите название центра.',
            'legal_name.required' => 'Пожалуйста, введите юридическое название центра.',

            'kpp.size' => 'КПП должен содержать ровно 9 символов.',
            'phone.required' => 'Укажите номер телефона.',
            'phone.regex' => 'Номер телефона имеет неверный формат.',
        ];
    }
}
