<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class EducationEnum extends Enum implements LocalizedEnum
{
    const Secondary = 1;             // Среднее
    const Vocational = 2;            // Среднее специальное
    const IncompleteHigher = 3;      // Неполное высшее
    const Higher = 4;                // Высшее
    const Master = 5;                // Магистр
    const Doctorate = 6;             // Доктор наук
}
