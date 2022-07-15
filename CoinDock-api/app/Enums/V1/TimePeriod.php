<?php

namespace App\Enums\V1;

use App\Enums\BaseEnum;

/**
 * @method static static Day
 * @method static static Weekly
 * @method static static Monthly
 * @method static static Yearly
 */
final class TimePeriod extends BaseEnum
{
    const Day = 0;
    const Weekly = 1;
    const Monthly = 2;
    const Yearly = 3;
}