<?php

namespace OMT\Module;

class Module
{
    public function __construct(array $data)
    {
        foreach ($data as $field => $value) {
            $this->{$field} = $value;
        }
    }

    public function render()
    {
        return null;
    }
}
