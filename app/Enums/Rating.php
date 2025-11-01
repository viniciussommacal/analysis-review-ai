<?php

namespace App\Enums;

class Rating
{
    const TERRIBLE = 1;
    const BAD = 2;
    const NEUTRAL = 3;
    const GOOD = 4;
    const EXCELLENT = 5;

    public static function values(): array
    {
        return [
            self::TERRIBLE,
            self::BAD,
            self::NEUTRAL,
            self::GOOD,
            self::EXCELLENT,
        ];
    }
}
