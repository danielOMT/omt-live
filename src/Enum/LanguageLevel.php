<?php

namespace OMT\Enum;

class LanguageLevel extends Enum
{
    public const BASIC = 1;
    public const ADVANCED = 2;
    public const FLUENT = 3;
    public const NATIVE = 4;

    public static function all()
    {
        return [
            self::BASIC => 'Grundkenntnisse',
            self::ADVANCED => 'Fortgeschritten',
            self::FLUENT => 'Fließend',
            self::NATIVE => 'Muttersprache'
        ];
    }
}
