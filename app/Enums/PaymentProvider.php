<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class PaymentProvider extends Enum implements LocalizedEnum
{
    const YooKassa = 0;
}
