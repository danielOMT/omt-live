<?php

namespace OMT\Filters;

class ToolReview extends Filter
{
    public function getImplemented()
    {
        return [
            'tool',
            'status'
        ];
    }

    protected function tool($toolId)
    {
        return $this->expressionIN('tool_id', $toolId);
    }

    protected function status($status)
    {
        $statuses = array_filter((array) $status);

        if (count($statuses)) {
            return $this->tableAlias . '.`status` IN (' . implode(',', array_map(fn ($value) => "'" . $value . "'", $statuses)) . ')';
        }

        return null;
    }
}
