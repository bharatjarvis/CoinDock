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
    const Inactive = 0;
    const Active = 1;
    const Used = 2;
}