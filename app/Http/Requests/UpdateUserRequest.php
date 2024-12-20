<?php

namespace App\Http\Requests;

use App\Enums\SubscriptionLevelEnum;
use App\Models\User;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UpdateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $array = [
            'photo' => [
                'nullable',
                File::image()
                    ->types(config('upload.support_images_formats'))
                    ->min(config('upload.image_min_size'))
                    ->max(config('upload.image_max_size'))
            ],
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'middlename' => [
                'nullable',
                'string',
                'max:255',
            ]
        ];

        if ($this->user()->can('updateSubscription', User::class))
        {
            $array = array_merge($array, [
                'subscription_level' => [
                    'required',
                    new EnumValue(SubscriptionLevelEnum::class)
                ],
                'subscription_ends_at' => [
                    'nullable',
                    'date'
                ],
            ]);
        }

        return $array;
    }

    public function attributes(): array
    {
        return __('user');
    }
}
