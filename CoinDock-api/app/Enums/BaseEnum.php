<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

abstract class BaseEnum extends Enum
{
    public function toArray(): mixed
    {
        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return $this;
    }
}