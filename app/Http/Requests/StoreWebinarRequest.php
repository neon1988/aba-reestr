<?php

namespace App\Http\Requests;

use App\Rules\FileExistsOnDiskRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreWebinarRequest extends FormRequest
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
        $rules = [
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'required',
                'string',
                'max:255',
            ],
            'start_at' => [
                'required',
                'date'
            ],
            $rules['cover'] = [
                'required',
                new FileExistsOnDiskRule()
            ]
        ];

        return $rules;
    }
}
