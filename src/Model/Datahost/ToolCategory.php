<?php

namespace OMT\Model\Datahost;

use OMT\Filters\ToolCategory as ToolCategoryFilters;

class ToolCategory extends Model
{
    protected function itemsConditions(array $filters = [])
    {
        return (new ToolCategoryFilters($this->getAlias()))->apply($filters);
    }

    protected function getTableName()
    {
        return 'tool_category';
    }
}
