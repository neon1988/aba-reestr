<?php

namespace App\Http\Requests;

use App\Enums\SubscriptionLevelEnum;
use App\Rules\FileExistsOnDiskRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreConferenceRequest extends FormRequest
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
                'required',
                new FileExistsOnDiskRule()
            ],
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
                'nullable',
                'numeric'
            ],
            'registration_url' => [
                'nullable',
                'url',
                Rule::requiredIf(fn () => !empty(request()->input('price')))
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
            'file' => [
                'nullable',
                new FileExistsOnDiskRule()
            ],
            'available_for_subscriptions' => [
                'nullable',
                'array',
            ],
            'available_for_subscriptions.*' => [
                'integer',
                Rule::in(SubscriptionLevelEnum::getValues())
            ],
            'url_button_text' => [
                'required',
                'string'
            ]
        ];

        return $rules;
    }

    public function attributes(): array
    {
        return __('conference.attributes');
    }
}
