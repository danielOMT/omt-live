<?php

namespace OMT\Model\Datahost;

use OMT\Enum\CategoryType;
use OMT\Model\PostModel;
use OMT\Services\Date;
use stdClass;

class Webinar extends Model
{
    const UPCOMING_WEBINARS = 'upcoming';
    const PAST_WEBINARS = 'past';
    const ALL_WEBINARS = 'all';

    const TIMEFRAME_NAME_UPCOMING = 'zukunft';
    const TIMEFRAME_NAME_PAST = 'vergangenheit';

    /**
     * Get list of active and published webinars
     *
     * - `order` has to be passed to options if need sorting
     * - `order_dir` default is ASC
     *
     * @param array $options Options such as order, order_dir, limit, with
     */
    public function activeItems(array $filters = [], array $options = [])
    {
        return $this->items(
            array_merge(['status' => PostModel::POST_STATUS_PUBLISH, 'hidden' => false], $filters),
            $options
        );
    }

    public function storeCategories(int $id, array $categories = [])
    {
        $model = Category::init();
        $relationshipModel = WebinarCategory::init();

        // Delete old "webinar_category" relationship
        $relationshipModel->delete(['webinar_id' => $id]);

        // Save or update new categories and create new "webinar_category" relationship
        foreach ($categories as $category) {
            $categoryId = $model->store([
                'id' => $category->term_id,
                'name' => $category->name,
                'slug' => $category->slug,
                'type' => CategoryType::WEBINAR
            ]);

            if ($categoryId) {
                $relationshipModel->store(
                    [
                        'webinar_id' => $id,
                        'category_id' => $category->term_id
                    ],
                    [
                        'timestamps' => false
                    ]
                );
            }
        }

        return true;
    }

    public function storeExperts(int $id, array $experts = [])
    {
        $model = Expert::init();
        $relationshipModel = WebinarExpert::init();

        // Delete old "webinar_expert" relationship
        $relationshipModel->delete(['webinar_id' => $id]);

        // Save or update new experts and create new "webinar_expert" relationship
        foreach ($experts as $expert) {
            $expertId = $model->store([
                'id' => $expert->ID,
                'name' => get_the_title($expert),
                'url' => get_the_permalink($expert)
            ]);

            if ($expertId) {
                $relationshipModel->store(
                    [
                        'webinar_id' => $id,
                        'expert_id' => $expertId
                    ],
                    [
                        'timestamps' => false
                    ]
                );
            }
        }

        return true;
    }

    public function destroy(int $id)
    {
        WebinarCategory::init()->delete(['webinar_id' => $id]);
        WebinarExpert::init()->delete(['webinar_id' => $id]);

        return parent::destroy($id);
    }

    protected function itemsConditions(array $filters = [])
    {
        $alias = $this->getAlias();
        $conditions = parent::itemsConditions($filters);

        if (array_key_exists('status', $filters) && count((array) $filters['status'])) {
            $conditions[] = $alias . '.`status` IN (' . implode(',', array_map(fn ($value) => "'" . $value . "'", (array) $filters['status'])) . ')';
        }

        if (array_key_exists('timeframe', $filters)) {
            // The webinar will be treated as "future" one hour after starts (->modify('-1 hour'))
            if ($filters['timeframe'] == self::UPCOMING_WEBINARS) {
                $conditions[] = $alias . ".`date` >= '" . Date::get()->modify('-1 hour')->format('Y-m-d H:i:s') . "'";
            } elseif ($filters['timeframe'] == self::PAST_WEBINARS) {
                $conditions[] = $alias . ".`date` < '" . Date::get()->modify('-1 hour')->format('Y-m-d H:i:s') . "'";
            }
        }

        if (array_key_exists('hidden', $filters)) {
            $conditions[] = $alias . '.`hidden` = ' . ($filters['hidden'] ? 1 : 0);
        }

        if (array_key_exists('expert', $filters)) {
            $experts = array_filter((array) $filters['expert']);

            if (count($experts)) {
                $conditions[] = 'w2e.`expert_id` IN (' . implode(',', $experts) . ')';
            }
        }

        if (array_key_exists('category', $filters)) {
            $categories = array_filter((array) $filters['category']);

            if (count($categories)) {
                $conditions[] = 'w2c.`category_id` IN (' . implode(',', $categories) . ')';
            }
        }

        return $conditions;
    }

    protected function itemsJoins(array $filters = [], array $options = [])
    {
        $joins = [];
        $alias = $this->getAlias();

        if (array_key_exists('expert', $filters) && count(array_filter((array) $filters['expert']))) {
            $joins[] = 'LEFT JOIN `' . WebinarExpert::init()->table() . '` AS w2e ON ' . $alias . '.`id` = w2e.`webinar_id`';
        }

        if (array_key_exists('category', $filters) && count(array_filter((array) $filters['category']))) {
            $joins[] = 'LEFT JOIN `' . WebinarCategory::init()->table() . '` AS w2c ON ' . $alias . '.`id` = w2c.`webinar_id`';
        }

        return $joins;
    }

    protected function extendItems(array $items = [], array $options = [])
    {
        // Append list of experts to the webinars
        if (in_array('experts', $options['with'])) {
            $webinarsToExperts = WebinarExpert::init()->items(['webinar' => array_map(fn ($item) => $item->id, $items)]);
            $expertsId = array_unique(array_map(fn ($value) => $value->expert_id, $webinarsToExperts));
            $experts = Expert::init()->items(['id' => $expertsId], [], OBJECT_K);

            foreach ($items as $item) {
                $itemExpertsId = array_map(
                    fn ($value) => $value->expert_id,
                    array_filter($webinarsToExperts, fn ($value) => $value->webinar_id == $item->id)
                );

                $item->experts = [];

                foreach ($itemExpertsId as $expertId) {
                    if (array_key_exists($expertId, $experts)) {
                        $item->experts[] = $experts[$expertId];
                    }
                }
            }
        }

        // Append extra data to the webinars
        foreach ($items as $item) {
            $item->extra ??= new stdClass;
            $item->extra->url = $this->itemUrl($item);
            $item->extra->timeframe = isWebinarAvailable($item)
                ? self::TIMEFRAME_NAME_UPCOMING
                : self::TIMEFRAME_NAME_PAST;
        }

        return $items;
    }

    protected function itemUrl(stdClass $item)
    {
        if (is_user_logged_in() && isWebinarAvailable($item)) {
            $user = wp_get_current_user();

            return $item->url . '?email=' . $user->user_email . '&firstname=' . $user->first_name . '&lastname=' . $user->last_name;
        }

        return $item->url;
    }

    protected function getTableName()
    {
        return 'webinars';
    }
}
