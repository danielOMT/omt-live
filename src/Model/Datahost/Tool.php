<?php

namespace OMT\Model\Datahost;

class Tool extends Model
{
    const STATUS_PUBLISH = 1;

    protected $tablePrefix = 'omt';

    protected function itemsConditions(array $filters = [])
    {
        $alias = $this->getAlias();
        $conditions = parent::itemsConditions($filters);

        if (isset($filters['status'])) {
            $conditions[] = $alias . '.`status` = ' . (int) $filters['status'];
        }

        if (isset($filters['hasTotalCost'])) {
            $conditions[] = $alias . '.`gesamtkosten` ' . ($filters['hasTotalCost'] ? '>' : '=') . ' 0';
        }

        return $conditions;
    }

    protected function getTableName()
    {
        return 'tools';
    }
}
