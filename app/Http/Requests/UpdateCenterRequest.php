<?php

namespace App\Http\Requests;

use App\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UpdateCenterRequest extends FormRequest
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
            'photo' => [
                'nullable',
                File::image()
                    ->types(config('upload.support_images_formats'))
                    ->min(config('upload.image_min_size'))
                    ->max(config('upload.image_max_size'))
            ],
            'phone' => [
                'required',
                'string',
                new PhoneRule(10, 15), // Используем кастомное правило для телефона
            ],
        ];
    }

    public function attributes(): array
    {
        return __('center');
    }
}
