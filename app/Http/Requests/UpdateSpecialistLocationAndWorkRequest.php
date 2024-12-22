<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSpecialistLocationAndWorkRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'country' => [
                'required',
                'string',
                'max:100',
                'exists:App\Models\Country,name',
            ],
            'region' => [
                'nullable',
                'string',
                'max:100',
            ],
            'city' => [
                'required',
                'string',
                'max:100',
            ],
            'center_name' => [
                'nullable',
                'string',
                'max:200',
            ],
            'curator' => [
                'nullable',
                'string',
                'max:200',
            ],
            'supervisor' => [
                'nullable',
                'string',
                'max:200',
            ],
            'professional_interests' => [
                'nullable',
                'string',
                'max:200',
            ],
        ];

    }

    public function attributes(): array
    {
        return __('specialist');
    }
}
