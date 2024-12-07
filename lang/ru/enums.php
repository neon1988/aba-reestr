<?php declare(strict_types=1);

use App\Enums\EducationEnum;

return [
    EducationEnum::class => [
        EducationEnum::Secondary => 'Среднее',
        EducationEnum::Vocational => 'Среднее специальное',
        EducationEnum::IncompleteHigher => 'Неполное высшее',
        EducationEnum::Higher => 'Высшее',
        EducationEnum::Master => 'Магистр',
        EducationEnum::Doctorate => 'Доктор наук',
    ],
];
