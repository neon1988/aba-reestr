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

    public function getPrice(): float
    {
        return match ($this->value) {
            self::Free => 0,
            self::ParentsAndRelated => 1900,
            self::Specialists => 3500,
            self::Centers => 4800,
            default => throw new \InvalidArgumentException('Unknown subscription level'),
        };
    }
}
