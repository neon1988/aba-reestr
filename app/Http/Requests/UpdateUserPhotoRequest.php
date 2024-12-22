<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UpdateUserPhotoRequest extends FormRequest
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
                File::image()
                    ->types(config('upload.support_images_formats'))
                    ->min(config('upload.image_min_size'))
                    ->max(config('upload.image_max_size'))
            ]
        ];
    }

    public function attributes(): array
    {
        return __('user');
    }
}
