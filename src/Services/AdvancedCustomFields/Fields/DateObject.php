<?php

namespace OMT\Services\AdvancedCustomFields\Fields;

use OMT\Services\Date as ServicesDate;

class DateObject extends Field
{
    public function getValue(int $postId = null, string $key, $rawValue)
    {
        return $rawValue;
    }

    public function format($value)
    {
        return ServicesDate::get($value);
    }
}
