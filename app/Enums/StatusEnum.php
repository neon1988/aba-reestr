<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class StatusEnum extends Enum implements LocalizedEnum
{
    const Accepted = 0;
    const OnReview = 1;
    const Rejected = 2;
    const Private = 3;
    const ReviewStarts = 4;
}
