<?php

namespace OMT\Model\Datahost;

use OMT\Enum\TrackingLinkType;
use OMT\Filters\MarketingTool as MarketingToolFilters;
use OMT\Model\PostModel;
use stdClass;

class MarketingTool extends Model
{
    /**
     * Get list of published tools
     *
     * - `order` has to be passed to options if need sorting
     * - `order_dir` default is ASC
     *
     * @param array $options Options such as order, order_dir, limit, with
     */
    public function activeItems(array $filters = [], array $options = [])
    {
        return $this->items(
            array_merge(['status' => PostModel::POST_STATUS_PUBLISH], $filters),
            $options
        );
    }

    public function alternatives($toolId, array $categories = [])
    {
        $options = [
            'group' => 'id',
            'limit' => 3,
            'order' => ['worth' => 'DESC', 'rating' => 'DESC', 'reviews_count' => 'DESC', 'preview_title' => 'ASC']
        ];

        return $this->activeItems([
            'not' => $toolId,
            'category' => $categories
        ], $options);
    }

    protected function extendItems(array $items = [], array $options = [])
    {
        // Append list of categories to the tools
        if (in_array('categories', $options['with'])) {
            $toolsToCategories = ToolCategory::init()->items(['tool' => array_map(fn ($item) => $item->id, $items)]);
            // $categoriesId = array_unique(array_map(fn ($value) => $value->category_id, $toolsToCategories));
            // $categories = Category::init()->items(['id' => $categoriesId], [], OBJECT_K);

            foreach ($items as $item) {
                $item->categories = [];
                $toolCategories = array_filter($toolsToCategories, fn ($value) => $value->tool_id == $item->id);

                foreach ($toolCategories as $toolCategory) {
                    $item->categories[$toolCategory->category_id] = $toolCategory;
                }
            }
        }

        // Append list of tracking links to the tools
        if (in_array('tracking_links', $options['with'])) {
            $toolsTrackingLinks = ToolTrackingLink::init()->items(['tool' => array_map(fn ($item) => $item->id, $items)]);

            foreach ($items as $item) {
                $item->tracking_links = [];
                $toolTrackingLinks = array_filter($toolsTrackingLinks, fn ($value) => $value->tool_id == $item->id);

                foreach ($toolTrackingLinks as $trackingLink) {
                    $item->tracking_links[$trackingLink->category_id] ??= new stdClass;
                    $item->tracking_links[$trackingLink->category_id]->{$trackingLink->type} = $trackingLink;
                }
            }
        }

        // Append list of details to the tools
        if (in_array('details', $options['with'])) {
            $toolsDetails = ToolDetail::init()->items(
                ['tool' => array_map(fn ($item) => $item->id, $items)],
                ['order' => 'order']
            );

            foreach ($items as $item) {
                $item->details = [];
                $toolDetails = array_filter($toolsDetails, fn ($value) => $value->tool_id == $item->id);

                foreach ($toolDetails as $detail) {
                    $item->details[$detail->category_id] ??= [];
                    $item->details[$detail->category_id][] = $detail->detail;
                }
            }
        }

        return $items;
    }

    public static function extractDetails(stdClass $tool, $category)
    {
        return $category && isset($tool->details[$category])
            ? array_slice($tool->details[$category], 0, 3)
            : array_slice($tool->details[0], 0, 3);
    }

    public static function extractPreviewText($tool, $category)
    {
        return $category
            ? $tool->categories[$category]->preview_text
            : $tool->preview_text;
    }

    public static function extractWebsiteTrackingLink($tool, $category)
    {
        return $category && !empty($tool->tracking_links[$category]->{TrackingLinkType::WEBSITE}->clickmeter_url)
            ? $tool->tracking_links[$category]->{TrackingLinkType::WEBSITE}->clickmeter_url
            : $tool->tracking_links[0]->{TrackingLinkType::WEBSITE}->clickmeter_url;
    }

    public static function extractPriceTrackingLink($tool, $category)
    {
        return $category && !empty($tool->tracking_links[$category]->{TrackingLinkType::PRICE_OVERVIEW}->clickmeter_url)
            ? $tool->tracking_links[$category]->{TrackingLinkType::PRICE_OVERVIEW}->clickmeter_url
            : $tool->tracking_links[0]->{TrackingLinkType::PRICE_OVERVIEW}->clickmeter_url;
    }

    public static function extractTestTrackingLink($tool, $category)
    {
        return $category && !empty($tool->tracking_links[$category]->{TrackingLinkType::TEST}->clickmeter_url)
            ? $tool->tracking_links[$category]->{TrackingLinkType::TEST}->clickmeter_url
            : $tool->tracking_links[0]->{TrackingLinkType::TEST}->clickmeter_url;
    }

    public function recalculateRatings(int $toolId)
    {
        $tool = $this->item(['id' => $toolId]);

        if ($tool) {
            $reviews = ToolReview::init()->activeItems([
                'tool' => $tool->id
            ]);

            $reviewsCount = count($reviews);

            $rating = $this->calculateRating($reviews, 'rating');
            $userFriendliness = $this->calculateRating($reviews, 'rating_user_friendliness');
            $сustomerService = $this->calculateRating($reviews, 'rating_customer_service');
            $features = $this->calculateRating($reviews, 'rating_features');
            $pricePerformance = $this->calculateRating($reviews, 'rating_price_performance');
            $recommendation = $this->calculateRating($reviews, 'rating_recommendation');

            // Update ACF rating fields in backend for the given tool
            update_field('anzahl_bewertungen', $reviewsCount, $tool->id);
            update_field('gesamt', $rating, $tool->id);
            update_field('benutzerfreundlichkeit', $userFriendliness, $tool->id);
            update_field('kundenservice', $сustomerService, $tool->id);
            update_field('funktionen', $features, $tool->id);
            update_field('preis-leistungs-verhaltnis', $pricePerformance, $tool->id);
            update_field('wahrscheinlichkeit_weiterempfehlung', $recommendation, $tool->id);

            return $this->update($tool, [
                'reviews_count' => $reviewsCount,
                'rating' => $rating,
                'rating_user_friendliness' => $userFriendliness,
                'rating_customer_service' => $сustomerService,
                'rating_features' => $features,
                'rating_price_performance' => $pricePerformance,
                'rating_recommendation' => $recommendation
            ]);
        }

        return false;
    }

    public function destroy(int $id)
    {
        ToolDetail::init()->delete(['tool_id' => $id]);
        ToolTrackingLink::init()->delete(['tool_id' => $id]);
        ToolCategory::init()->delete(['tool_id' => $id]);

        return parent::destroy($id);
    }

    protected function itemsConditions(array $filters = [])
    {
        return (new MarketingToolFilters($this->getAlias()))->apply($filters);
    }

    protected function itemsJoins(array $filters = [], array $options = [])
    {
        $joins = [];
        $alias = $this->getAlias();

        if (array_key_exists('category', $filters) && count(array_filter((array) $filters['category']))) {
            $joins[] = 'LEFT JOIN `' . ToolCategory::init()->table() . '` AS t2c ON ' . $alias . '.`id` = t2c.`tool_id`';
        }

        return $joins;
    }

    protected function calculateRating(array $reviews, string $field)
    {
        return count($reviews)
            ? array_reduce($reviews, fn ($carry, $item) => $carry + $item->{$field}) / count($reviews)
            : 0;
    }

    protected function getTableName()
    {
        return 'tools';
    }
}
