<?php

namespace OMT\Filters;

class ToolCategory extends Filter
{
    public function getImplemented()
    {
        return [
            'tool',
        ];
    }

    protected function tool($toolId)
    {
        return $this->expressionIN('tool_id', $toolId);
    }
}
