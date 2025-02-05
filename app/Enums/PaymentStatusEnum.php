<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class PaymentStatusEnum extends Enum implements LocalizedEnum
{
    const PENDING = 0;
    const SUCCEEDED = 1;
    const CANCELED = 2;
    const WAITING_FOR_CAPTURE = 3;
    const DECLINED = 4;
    const WAITING_FOR_PAYMENT = 5;
}
