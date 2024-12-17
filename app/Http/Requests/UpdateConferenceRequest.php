<?php

namespace App\Http\Requests;

use App\Rules\FileExistsOnDiskRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateConferenceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'cover' => [
                'nullable',
                new FileExistsOnDiskRule()
            ],
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'required',
                'string'
            ],
            'stream_url' => [
                'nullable',
                'url'
            ],
            'start_at' => [
                'required',
                'date'
            ],
            'end_at' => [
                'required',
                'date',
                'after:start_at',
            ],
            'file' => [
                'nullable',
                new FileExistsOnDiskRule()
            ]
        ];

        return $rules;
    }

    public function attributes(): array
    {
        return __('conference.attributes');
    }
}
