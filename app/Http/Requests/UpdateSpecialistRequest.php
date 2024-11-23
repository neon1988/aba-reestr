<?php

namespace App\Http\Requests;

use App\Rules\PhoneRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

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
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:' . config('uploads.image_max_size'),
            ],
            'phone' => [
                'required',
                'string',
                new PhoneRule(10, 15), // Используем кастомное правило Phone
            ],
        ];

    }

    public function attributes(): array
    {
        return __('specialist');
    }
}
