<?php

namespace App\Enums\V1;

use BenSampo\Enum\Enum;

/**
 * @method static static Active
 * @method static static Inactive
 * @method static static Used
 */
final class RecoveryKeyStatus extends Enum
{
    const Active = 0;
    const Inactive = 1;
    const Used = 2;
}