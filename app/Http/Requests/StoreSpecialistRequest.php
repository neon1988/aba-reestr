<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:'.config('uploads.image_max_size'),
            'lastname' => 'required|string|max:50',  // Обязательно, строка, максимум 50 символов
            'firstname' => 'required|string|max:50',  // Обязательно, строка, максимум 50 символов
            'middlename' => 'nullable|string|max:50',  // Необязательно, строка, максимум 50 символов
            'country' => 'required|string|max:100|exists:App\Models\Country,name',  // Обязательно, строка, максимум 100 символов
            'region' => 'nullable|string|max:100',  // Необязательно, строка, максимум 100 символов
            'city' => 'required|string|max:100',  // Обязательно, строка, максимум 100 символов
            'education' => 'required|string|max:255',  // Обязательно, строка, максимум 255 символов
            'phone' => 'required|string|regex:/^\+?[0-9]{10,15}$/',  // Обязательно, строка, проверка формата телефона (10–15 цифр с опциональным "+")
            'file' => 'required|file|max:'.config('uploads.document_max_size')
        ];
    }

    public function messages()
    {
        return [
            'lastname.required' => 'Фамилия является обязательным полем.',
            'lastname.string' => 'Фамилия должна быть строкой.',
            'lastname.max' => 'Фамилия не может превышать 50 символов.',

            'firstname.required' => 'Имя является обязательным полем.',
            'firstname.string' => 'Имя должно быть строкой.',
            'firstname.max' => 'Имя не может превышать 50 символов.',

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
