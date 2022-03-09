<?php

namespace OMT\Enum;

class ToolRating extends Enum
{
    public const AWFUL = 1;
    public const NOT_GOOD = 2;
    public const NEUTRAL = 3;
    public const MOSTLY_GOOD = 4;
    public const OUTSTANDING = 5;

    public static function all()
    {
        return [
            self::AWFUL => 'Furchtbar',
            self::NOT_GOOD => 'Nicht gut',
            self::NEUTRAL => 'Neutral',
            self::MOSTLY_GOOD => 'Vorwiegend gut',
            self::OUTSTANDING => 'Herausragend'
        ];
    }

    public static function getKey($value)
    {
        return array_search($value, self::all());
    }
}
