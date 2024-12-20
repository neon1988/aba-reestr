<?php declare(strict_types=1);

use App\Enums\EducationEnum;
use App\Enums\SubscriptionLevelEnum;

return [
    EducationEnum::class => [
        EducationEnum::Secondary => 'Среднее',
        EducationEnum::Vocational => 'Среднее специальное',
        EducationEnum::IncompleteHigher => 'Неполное высшее',
        EducationEnum::Higher => 'Высшее',
        EducationEnum::Master => 'Магистр',
        EducationEnum::Doctorate => 'Доктор наук',
    ],
    SubscriptionLevelEnum::class => [
        SubscriptionLevelEnum::Free => 'Без подписки',
        SubscriptionLevelEnum::ParentsAndRelated => 'Родители и смежники',
        SubscriptionLevelEnum::Specialists => 'Специалисты',
        SubscriptionLevelEnum::Centers => 'Центры',
    ],
];
