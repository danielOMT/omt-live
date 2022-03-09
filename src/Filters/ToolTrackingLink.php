<?php

namespace OMT\Filters;

class ToolTrackingLink extends Filter
{
    public function getImplemented()
    {
        return [
            'tool',
            'category',
            'type'
        ];
    }

    protected function tool($toolId)
    {
        return $this->expressionIN('tool_id', $toolId);
    }

    protected function category($categoryId)
    {
        return $this->expressionIN('category_id', $categoryId);
    }

    protected function type($type)
    {
        return $this->expressionEqual('type', $type);
    }
}
