<?php

namespace App\Http\Requests;

use App\Rules\FileExistsOnDiskRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreWebinarRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'required',
                'string',
            ],
            'start_at' => [
                'required',
                'date'
            ],
            'end_at' => [
                'nullable',
                'date',
                'after:start_at',
            ],
            'stream_url' => [
                'required',
                'url'
            ],
            'price' => [
                'nullable',
                'numeric'
            ],
            'cover' => [
                'required',
                new FileExistsOnDiskRule()
            ]
        ];

        return $rules;
    }

    public function attributes(): array
    {
        return __('webinar.attributes');
    }
}
