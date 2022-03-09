<?php

namespace OMT\Model\Datahost;

use OMT\Filters\ToolReview as ToolReviewFilters;
use OMT\Model\PostModel;

class ToolReview extends Model
{
    /**
     * Get list of published and private reviews
     *
     * - `order` has to be passed to options if need sorting
     * - `order_dir` default is ASC
     *
     * @param array $options Options such as order, order_dir, limit, with
     */
    public function activeItems(array $filters = [], array $options = [])
    {
        return $this->items(
            array_merge(['status' => [PostModel::POST_STATUS_PUBLISH, PostModel::POST_STATUS_PRIVATE]], $filters),
            $options
        );
    }

    protected function itemsConditions(array $filters = [])
    {
        return (new ToolReviewFilters($this->getAlias()))->apply($filters);
    }

    /**
     * Delete tool review and recalculate ratings for the given tool
     */
    public function destroy(int $id)
    {
        $item = $this->item(['id' => $id]);

        if ($item && parent::destroy($id)) {
            MarketingTool::init()->recalculateRatings($item->tool_id);

            return true;
        }

        return false;
    }

    protected function getTableName()
    {
        return 'tool_reviews';
    }
}
