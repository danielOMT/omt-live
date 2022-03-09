<?php

namespace OMT\Enum;

class CategoryType extends Enum
{
    public const WEBINAR = 1;
    public const TOOL = 2;

    public static function all()
    {
        return [
            self::WEBINAR => 'Webinar',
            self::TOOL => 'Tool'
        ];
    }
}
