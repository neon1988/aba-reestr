<?php

namespace App\Http\Requests;

use App\Rules\PhoneRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UpdateSpecialistPhotoRequest extends FormRequest
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
                'nullable',
                File::image()
                    ->types(config('upload.support_images_formats'))
                    ->min(config('upload.image_min_size'))
                    ->max(config('upload.image_max_size'))
            ]
        ];

    }

    public function attributes(): array
    {
        return __('specialist');
    }
}
