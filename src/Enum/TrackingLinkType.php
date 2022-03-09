<?php

namespace OMT\Enum;

class TrackingLinkType extends Enum
{
    public const WEBSITE = 'website';
    public const PRICE_OVERVIEW = 'price_overview';
    public const TEST = 'test';

    public static function all()
    {
        return [
            self::WEBSITE => 'Website',
            self::PRICE_OVERVIEW => 'Preisübersicht',
            self::TEST => 'Tool Testen'
        ];
    }
}
