<?php

namespace OMT\Services\AdvancedCustomFields\Fields;

abstract class Field
{
    abstract public function getValue(int $postId = null, string $key, $rawValue);

    abstract public function format($value);
}
