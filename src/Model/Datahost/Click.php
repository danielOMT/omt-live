<?php

namespace OMT\Model\Datahost;

use DateTimeZone;
use stdClass;

class Click extends Model
{
    protected $tablePrefix = 'omt';

    public function statsItems($toolId, int $from, int $to)
    {
        $items = $this->db->get_results("SELECT * FROM `" . $this->table() . "` WHERE `tool_id` = " . (int) $toolId . " AND `timestamp_unix` > " . $from . " AND `timestamp_unix` < " . $to . " ORDER BY `timestamp_unix` DESC");

        foreach ($items as $item) {
            $item->extra ??= new stdClass;
            $item->extra->date = date_create_from_format("U", $item->timestamp_unix + 7200, new DateTimeZone('Europe/Amsterdam'));
            $item->extra->category = $item->toolkategorie_id != 0
                ? get_the_category_by_ID($item->toolkategorie_id)
                : "Toolseite";
        }

        return $items;
    }

    protected function itemsConditions(array $filters = [])
    {
        $alias = $this->getAlias();
        $conditions = parent::itemsConditions($filters);

        if (isset($filters['categoryAssigned'])) {
            $conditions[] = $alias . '.`toolkategorie_id` ' . ($filters['categoryAssigned'] ? '>' : '=') . ' 0';
        }

        if (isset($filters['bid'])) {
            $conditions[] = $alias . '.`bid_id` = ' . (int) $filters['bid'];
        }

        if (isset($filters['tool'])) {
            if (is_array($filters['tool']) && count($filters['tool'])) {
                $conditions[] = $alias . '.`tool_id` IN (' . implode(',', array_map('intval', $filters['tool'])) . ')';
            } else {
                $conditions[] = $alias . '.`tool_id` = ' . (int) $filters['tool'];
            }
        }

        return $conditions;
    }

    protected function getTableName()
    {
        return 'clicks';
    }
}
