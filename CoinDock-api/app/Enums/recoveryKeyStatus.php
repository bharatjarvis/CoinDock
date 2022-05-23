<?php

namespace App\Enums\V1;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class recoveryKeyStatus extends Enum
{
    const Active =   0;
    const Inactive =   1;
    const Used = 2;
}
