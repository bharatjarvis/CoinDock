<?php

namespace App\Enums\V1;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class userStatus extends Enum
{
    const Active =   0;
    const InActive =   1;
    const Locked = 2;
}
