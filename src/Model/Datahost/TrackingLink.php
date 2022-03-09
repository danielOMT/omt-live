<?php

namespace OMT\Model\Datahost;

class TrackingLink extends Model
{
    protected $tablePrefix = 'omt';

    protected function getTableName()
    {
        return 'trackinglinks';
    }
}
