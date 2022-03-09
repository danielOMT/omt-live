<?php

namespace OMT\Enum;

class JobStatus extends Enum
{
    public const NOT_LOOKING = 1;
    public const LOOKING_OCCASIONALLY = 2;
    public const LOOKING_ACTIVE = 3;

    public static function all()
    {
        return [
            self::NOT_LOOKING => 'Ich schaue mir aktuell keine Stellenanzeigen an',
            self::LOOKING_OCCASIONALLY => 'Ich schaue mir gelegentlich Stellenanzeigen an',
            self::LOOKING_ACTIVE => 'Ich bin aktiv auf Jobsuche'
        ];
    }
}
