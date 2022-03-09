<?php

namespace OMT\Enum;

abstract class Enum
{
    abstract public static function all();

    public static function keys()
    {
        return array_keys(static::all());
    }
}
