<?php

namespace OMT\Model\Datahost;

use OMT\Filters\ToolTrackingLink as ToolTrackingLinkFilters;

class ToolTrackingLink extends Model
{
    protected function itemsConditions(array $filters = [])
    {
        return (new ToolTrackingLinkFilters($this->getAlias()))->apply($filters);
    }

    protected function getTableName()
    {
        return 'tool_tracking_links';
    }
}
