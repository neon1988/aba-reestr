<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class SubscriptionLevelEnum extends Enum implements LocalizedEnum
{
    const Free = 0;
    const A = 1;
    const B = 2;
    const C = 3;

    public function getPrice(): float
    {
        return match ($this->value) {
            self::Free => 0,
            self::A => 3500,
            self::B => 5500,
            self::C => 6000,
            default => throw new \InvalidArgumentException('Unknown subscription level'),
        };
    }
}
