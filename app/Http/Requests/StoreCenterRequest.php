<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:'.config('uploads.image_max_size'),
            'name' => 'required|string|max:255', // Обязательное, строка, максимум 255 символов
            'legal_name' => 'required|string|max:255', // Обязательное, строка, максимум 255 символов
            'inn' => 'required|string|size:10', // Обязательное, строка, ровно 10 символов
            'kpp' => 'nullable|string|size:9', // Необязательное, строка, ровно 9 символов (если применимо)
            'country' => 'required|string|max:100|exists:App\Models\Country,name', // Обязательное, строка, максимум 100 символов
            'region' => 'nullable|string|max:100', // Обязательное, строка, максимум 100 символов
            'city' => 'required|string|max:100', // Обязательное, строка, максимум 100 символов
            'phone' => 'required|string|regex:/^\+?[0-9\s\-\(\)]+$/|min:10|max:15', // Обязательное, строка, формат номера телефона, от 10 до 15 символов
            'file' => 'required|file|max:'.config('uploads.document_max_size')
        ];
    }

    /**
     * Сообщения об ошибках для валидации (опционально).
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Пожалуйста, введите название центра.',
            'legal_name.required' => 'Пожалуйста, введите юридическое название центра.',
            'inn.required' => 'ИНН обязателен для заполнения и должен содержать 10 символов.',
            'inn.size' => 'ИНН должен содержать ровно 10 символов.',
            'kpp.size' => 'КПП должен содержать ровно 9 символов.',
            'phone.required' => 'Укажите номер телефона.',
            'phone.regex' => 'Номер телефона имеет неверный формат.',
        ];
    }
}
