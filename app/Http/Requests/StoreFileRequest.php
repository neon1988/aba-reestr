<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class StoreFileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'file' => [
                'required',
                File::default()->min(config('upload.document_min_size'))
                    ->max(config('upload.document_max_size'))
            ],
        ];
    }

    public function attributes(): array
    {
        return __('file.attributes');
    }
}
