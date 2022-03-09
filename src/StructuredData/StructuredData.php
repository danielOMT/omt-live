<?php

namespace OMT\StructuredData;

use stdClass;

abstract class StructuredData
{
    protected $entity = null;

    public function __construct(stdClass $entity)
    {
        $this->entity = $entity;
    }

    public static function init(stdClass $entity)
    {
        return new static($entity);
    }

    abstract public function render();
}
