<?php

namespace OMT\Services;

use stdClass;

class ToolCategoryClicks
{
    public static function totalByCategory(int $categoryId, array $clicks)
    {
        return self::count($clicks, ['category' => $categoryId]);
    }

    public static function totalByMonth(stdClass $month, array $clicks)
    {
        return self::count($clicks, ['month' => $month]);
    }

    public static function byMonth(int $categoryId, stdClass $month, array $clicks)
    {
        return self::count($clicks, [
            'category' => $categoryId,
            'month' => $month
        ]);
    }

    public static function grabToolsCategories(array $clicks)
    {
        return array_values(array_unique(array_map(fn ($click) => $click->toolkategorie_id, $clicks)));
    }

    protected static function count(array $clicks, array $filters)
    {
        return count(array_filter($clicks, function ($click) use ($filters) {
            if (isset($filters['category']) && $filters['category'] != $click->toolkategorie_id) {
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
