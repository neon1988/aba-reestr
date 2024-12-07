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
use Illuminate\Validation\Rules\File;

class StoreCenterRequest extends FormRequest
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
            'phone' => [
                'required',
                'string',
                new PhoneRule(),
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
