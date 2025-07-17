<?php

namespace App\Http\Requests;

use App\Rules\FileExistsOnDiskRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateWorksheetRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'required',
                'string',
            ],
            'price' => [
                'required',
                'numeric'
            ],
            'cover' => [
                'required',
                new FileExistsOnDiskRule()
            ],
            'file' => [
                'required',
                new FileExistsOnDiskRule()
            ],
            'tags' => [
                'nullable',
                'array'
            ]
        ];
    }

    public function attributes(): array
    {
        return __('worksheet.attributes');
    }
}
