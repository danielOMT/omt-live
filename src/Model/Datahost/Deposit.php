<?php

namespace OMT\Model\Datahost;

class Deposit extends Model
{
    protected $tablePrefix = 'omt';

    protected function getTableName()
    {
        return 'einzahlungen';
    }
}
