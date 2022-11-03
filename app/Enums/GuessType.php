<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class GuessType extends Enum
{
    public const WIN = 1;
    public const EQUAL = 2;
    public const LOSE = 3;
}
