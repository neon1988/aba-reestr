<?php

namespace App\Http\Requests;

use App\Rules\PhoneRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UpdateSpecialistLocationAndWorkRequest extends FormRequest
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
                'required',
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
