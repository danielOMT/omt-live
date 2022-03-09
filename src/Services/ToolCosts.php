<?php

namespace OMT\Services;

use stdClass;

class ToolCosts
{
    public static function total(int $toolId, array $clicks)
    {
        return self::cost(
            self::filter($clicks, ['tool' => $toolId])
        );
    }

    public static function byMonth(int $toolId, stdClass $month, array $clicks)
    {
        return self::cost(
            self::filter($clicks, [
                'tool' => $toolId,
                'month' => $month
            ])
        );
    }

    public static function grabTools(array $clicks)
    {
        return array_values(array_unique(array_map(fn ($click) => $click->tool_id, $clicks)));
    }

    public static function cost(array $clicks)
    {
        return array_sum(array_map(fn ($click) => $click->bid_kosten, $clicks));
    }

    protected static function filter(array $clicks, array $filters)
    {
        return array_filter($clicks, function ($click) use ($filters) {
            if (isset($filters['tool']) && $filters['tool'] != $click->tool_id) {
                return false;
            }

            // Will be compared GMT timezone as timestamp_unix is GMT and startTimestamp, endTimestamp is also GMT
            if (isset($filters['month']) && !($click->timestamp_unix >= $filters['month']->startTimestamp && $click->timestamp_unix <= $filters['month']->endTimestamp)) {
                return false;
            }

            return true;
        });
    }
}
