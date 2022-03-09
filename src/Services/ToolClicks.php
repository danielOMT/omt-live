<?php

namespace OMT\Services;

use stdClass;

class ToolClicks
{
    public static function totalByTool(int $toolId, array $clicks)
    {
        return self::count($clicks, ['tool' => $toolId]);
    }

    public static function totalByMonth(stdClass $month, array $clicks)
    {
        return self::count($clicks, ['month' => $month]);
    }

    public static function byMonth(int $toolId, stdClass $month, array $clicks)
    {
        return self::count($clicks, [
            'tool' => $toolId,
            'month' => $month
        ]);
    }

    public static function grabTools(array $clicks)
    {
        return array_values(array_unique(array_map(fn ($click) => $click->tool_id, $clicks)));
    }

    protected static function count(array $clicks, array $filters)
    {
        return count(array_filter($clicks, function ($click) use ($filters) {
            if (isset($filters['tool']) && $filters['tool'] != $click->tool_id) {
                return false;
            }

            // Will be compared GMT timezone as timestamp_unix is GMT and startTimestamp, endTimestamp is also GMT
            if (isset($filters['month']) && !($click->timestamp_unix >= $filters['month']->startTimestamp && $click->timestamp_unix <= $filters['month']->endTimestamp)) {
                return false;
            }

            return true;
        }));
    }
}
