<?php

namespace OMT\Filters;

class ToolDetail extends Filter
{
    public function getImplemented()
    {
        return [
            'tool',
            'category'
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
}
