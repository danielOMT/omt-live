<?php

namespace OMT\Filters;

use OMT\Enum\ToolPricePlan;

class MarketingTool extends Filter
{
    public function getImplemented()
    {
        return [
            'status',
            'category',
            'not',
            'plan',
            'hasReview',
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

    protected function category($category)
    {
        $categories = array_filter((array) $category);

        if (count($categories)) {
            return 't2c.`category_id` IN (' . implode(',', $categories) . ')';
        }

        return null;
    }

    protected function not($id)
    {
        $ids = array_filter((array) $id);

        if (count($ids)) {
            return $this->expressionNotIN('id', $ids);
        }

        return null;
    }

    protected function plan($plan)
    {
        switch ($plan) {
            case ToolPricePlan::FREE:
                return $this->expressionTrueFalse('has_free_plan', true);

            case ToolPricePlan::PAID:
                return $this->expressionTrueFalse('has_paid_plan', true);

            case ToolPricePlan::TEST:
                return $this->expressionTrueFalse('has_test_plan', true);

            case ToolPricePlan::TRIAL:
                return $this->expressionTrueFalse('has_trial_plan', true);
        }

        return null;
    }

    protected function hasReview(bool $flag)
    {
        return $this->expressionTrueFalse('has_review', $flag);
    }
}
