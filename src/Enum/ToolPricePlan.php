<?php

namespace OMT\Enum;

class ToolPricePlan extends Enum
{
    public const FREE = 'kostenlos';
    public const PAID = 'nicht-kostenlos';
    public const TEST = 'testversion';
    public const TRIAL = 'trial';

    public static function all()
    {
        return [
            self::FREE => 'Kostenlos',
            self::PAID => 'Nicht Kostenlos',
            self::TEST => 'kostenlose Testversion',
            self::TRIAL => 'kostenlose Testphase'
        ];
    }
}
