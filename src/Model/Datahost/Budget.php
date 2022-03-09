<?php

namespace OMT\Model\Datahost;

class Budget extends Model
{
    protected $tablePrefix = 'omt';

    protected function getTableName()
    {
        return 'budgets';
    }
}
