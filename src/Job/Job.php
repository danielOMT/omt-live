<?php

namespace OMT\Job;

abstract class Job
{
    public static function init()
    {
        return new static();
    }
}
