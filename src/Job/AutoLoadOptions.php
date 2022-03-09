<?php

namespace OMT\Job;

class AutoLoadOptions extends Job
{
    public function __construct()
    {
        add_filter('acf/settings/autoload', [$this, 'setAutoloadForAcfOptions']);
    }

    public function setAutoloadForAcfOptions($value)
    {
        return true;
    }
}
