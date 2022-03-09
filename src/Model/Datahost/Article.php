<?php

namespace OMT\Model\Datahost;

use OMT\Filters\Article as ArticleFilters;
use OMT\Model\PostModel;

class Article extends Model
{
    /**
     * Get list of published articles
     *
     * - `order` has to be passed to options if need sorting
     * - `order_dir` default is ASC
     *
     * @param array $options Options such as order, order_dir, group, limit, with
     */
    public function activeItems(array $filters = [], array $options = [], $output = OBJECT)
    {
        return $this->items(
            array_merge(['status' => PostModel::POST_STATUS_PUBLISH, 'recap' => false], $filters),
            $options,
            $output
        );
    }

    protected function itemsConditions(array $filters = [])
    {
        return (new ArticleFilters($this->getAlias()))->apply($filters);
    }

    protected function itemsJoins(array $filters = [], array $options = [])
    {
        $joins = [];
        $alias = $this->getAlias();

        if (array_key_exists('expert', $filters) && count(array_filter((array) $filters['expert']))) {
            $joins[] = 'LEFT JOIN `' . ArticleExpert::init()->table() . '` AS a2e ON ' . $alias . '.`id` = a2e.`article_id`';
        }

        return $joins;
    }

    protected function extendItems(array $items = [], array $options = [])
    {
        // Append list of experts to the articles
        if (in_array('experts', $options['with'])) {
            $articlesToExperts = ArticleExpert::init()->items(['article' => array_map(fn ($item) => $item->id, $items)]);
            $expertsId = array_unique(array_map(fn ($value) => $value->expert_id, $articlesToExperts));
            $experts = Expert::init()->items(['id' => $expertsId], [], OBJECT_K);

            foreach ($items as $item) {
                $itemExpertsId = array_map(
                    fn ($value) => $value->expert_id,
                    array_filter($articlesToExperts, fn ($value) => $value->article_id == $item->id)
                );

                $item->experts = [];

                foreach ($itemExpertsId as $expertId) {
                    if (array_key_exists($expertId, $experts)) {
                        $item->experts[] = $experts[$expertId];
                    }
                }
            }
        }

        return $items;
    }

    public function destroy(int $id)
    {
        ArticleExpert::init()->delete(['article_id' => $id]);

        return parent::destroy($id);
    }

    protected function getTableName()
    {
        return 'articles';
    }
}
