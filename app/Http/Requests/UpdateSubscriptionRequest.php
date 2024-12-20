<?php

namespace App\Http\Requests;

use App\Enums\SubscriptionLevelEnum;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSubscriptionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'subscription_level' => [
                'required',
                new EnumValue(SubscriptionLevelEnum::class)
            ],
            'subscription_ends_at' => [
                'nullable',
                'date'
            ],
        ];
    }
}
