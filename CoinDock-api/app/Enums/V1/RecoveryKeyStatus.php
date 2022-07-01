<?php

namespace App\Enums\V1;

use App\Enums\BaseEnum;

/**
 * @method static static Active
 * @method static static Inactive
 * @method static static Used
 */
final class RecoveryKeyStatus extends BaseEnum
{
    const Active = 0;
    const Inactive = 1;
    const Used = 2;
}