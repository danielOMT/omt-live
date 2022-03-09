<?php

namespace OMT\Enum;

class Experience extends Enum
{
    public const NO_EXPERIENCE = 1;
    public const LESS_ONE_YEAR = 2;
    public const ONE_TWO_YEARS = 3;
    public const THREE_FIVE_YEARS = 4;
    public const FIVE_TEN_YEARS = 5;
    public const OVER_TEN_YEARS = 6;

    public static function all()
    {
        return [
            self::NO_EXPERIENCE => 'Keine Berufserfahrung im Online Marketing',
            self::LESS_ONE_YEAR => 'weniger als 1 Jahr',
            self::ONE_TWO_YEARS => '1-2 Jahre',
            self::THREE_FIVE_YEARS => '3-5 Jahre',
            self::FIVE_TEN_YEARS => '5-10 Jahre',
            self::OVER_TEN_YEARS => 'Über 10 Jahre'
        ];
    }
}
