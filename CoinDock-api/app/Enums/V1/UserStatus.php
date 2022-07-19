<?php

namespace App\Enums\V1;

use App\Enums\BaseEnum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class UserStatus extends BaseEnum
{
    const Inactive = 0;
    const Active = 1;
    const Locked = 2;
}