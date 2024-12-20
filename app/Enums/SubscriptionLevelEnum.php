<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class SubscriptionLevelEnum extends Enum implements LocalizedEnum
{
    const Free = 0;
    const ParentsAndRelated = 1;
    const Specialists = 2;
    const Centers = 3;
}
