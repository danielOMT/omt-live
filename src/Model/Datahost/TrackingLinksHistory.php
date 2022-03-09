<?php

namespace OMT\Model\Datahost;

class TrackingLinksHistory extends Model
{
    const ACTION_UPDATED = 1;
    const ACTION_DELETED = 2;

    protected function itemsConditions(array $filters = [])
    {
        $alias = $this->getAlias();
        $conditions = parent::itemsConditions($filters);

        if (array_key_exists('tool', $filters)) {
            $toolIds = array_filter((array) $filters['tool']);

            if (count($toolIds)) {
                $conditions[] = $alias . '.`tool_id` IN (' . implode(',', $toolIds) . ')';
            }
        }

        return $conditions;
    }

    protected function extendItems(array $items = [], array $options = [])
    {
        if (in_array('category', $options['with'])) {
            foreach ($items as $item) {
                $item->category = $item->category_id
                    ? get_term_by('id', $item->category_id, 'tooltyp')
                    : null;
            }
        }

        return $items;
    }

    protected function getTableName()
    {
        return 'tracking_links_history';
    }
}
