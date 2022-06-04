<?php

namespace App\Enums\V1;

use App\Enums\BaseEnum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class UserType extends BaseEnum
{
    const User = 0;
    const Admin = 1;
};