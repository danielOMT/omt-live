<?php

namespace OMT\Model\Datahost;

use OMT\Filters\ToolDetail as ToolDetailFilters;

class ToolDetail extends Model
{
    protected function itemsConditions(array $filters = [])
    {
        return [
            ...parent::itemsConditions($filters),
            ...(new ToolDetailFilters($this->getAlias()))->apply($filters)
        ];
    }

    protected function getTableName()
    {
        return 'tool_details';
    }
}
