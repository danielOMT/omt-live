<?php

namespace OMT\Model\Datahost;

class WebinarExpert extends Model
{
    protected function itemsConditions(array $filters = [])
    {
        $alias = $this->getAlias();
        $conditions = parent::itemsConditions($filters);

        if (array_key_exists('webinar', $filters)) {
            $webinars = array_filter((array) $filters['webinar']);

            if (count($webinars)) {
                $conditions[] = $alias . '.`webinar_id` IN (' . implode(',', $webinars) . ')';
            }
        }

        return $conditions;
    }

    protected function getTableName()
    {
        return 'webinar_expert';
    }
}
