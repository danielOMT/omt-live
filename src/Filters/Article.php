<?php

namespace OMT\Filters;

class Article extends Filter
{
    public function getImplemented()
    {
        return [
            'status',
            'postType',
            'recap',
            'expert'
        ];
    }

    protected function status($status)
    {
        $statuses = array_filter((array) $status);

        if (count($statuses)) {
            return $this->tableAlias . '.`status` IN (' . implode(',', array_map(fn ($value) => "'" . $value . "'", $statuses)) . ')';
        }

        return null;
    }

    protected function postType($postType)
    {
        $postTypes = array_filter((array) $postType);

        if (count($postTypes)) {
            return $this->tableAlias . '.`post_type` IN (' . implode(',', array_map(fn ($value) => "'" . $value . "'", $postTypes)) . ')';
        }

        return null;
    }

    protected function recap(bool $flag)
    {
        return $this->expressionTrueFalse('recap', $flag);
    }

    protected function expert($expert)
    {
        $experts = array_filter((array) $expert);

        if (count($experts)) {
            return 'a2e.`expert_id` IN (' . implode(',', $experts) . ')';
        }

        return null;
    }
}
