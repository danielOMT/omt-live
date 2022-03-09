<?php

namespace OMT\Services;

use OMT\API\ClickMeter;
use OMT\Enum\TrackingLinkType;
use OMT\Model\Datahost\Bid;
use OMT\Model\Datahost\Click;
use OMT\Model\PostModel;
use OMT\Model\Tool;
use stdClass;

class ToolTrackingLinks
{
    /**
     * Get tool tracking links included categories links
     * Old stuff logic, only refactored
     */
    public function links(int $toolId, $skipNull = true)
    {
        $trackingLinks = [];
        $toolName = get_the_title($toolId);

        // TODO: refactor to use this function for /toolanbieter "Budgets/Gebote" page
        $toolanbieter_website_clickmeter_link_id = get_field('toolanbieter_website_clickmeter_link_id', $toolId);
        $tool_preisubersicht_clickmeter_link_id = get_field('tool_preisubersicht_clickmeter_link_id', $toolId);
        $tool_gratis_testen_link_clickmeter_link_id = get_field('tool_gratis_testen_link_clickmeter_link_id', $toolId);

        // Push Website Link into array if available, or $skipNull is false
        if ($toolanbieter_website_clickmeter_link_id > 0 || !$skipNull) {
            array_push($trackingLinks, (object) [
                'type' => TrackingLinkType::WEBSITE,
                'link_id' => $toolanbieter_website_clickmeter_link_id,
                'tracking_link' => get_field('zur_webseite', $toolId),
                'tool_id' => $toolId,
                'tool_name' => $toolName,
                'category_id' => 0,
                'category_name' => ""
            ]);
        }

        // Push Price Link into array if available, or $skipNull is false
        if ($tool_preisubersicht_clickmeter_link_id > 0 || !$skipNull) {
            array_push($trackingLinks, (object) [
                'type' => TrackingLinkType::PRICE_OVERVIEW,
                'link_id' => $tool_preisubersicht_clickmeter_link_id,
                'tracking_link' => get_field('tool_preisubersicht', $toolId),
                'tool_id' => $toolId,
                'tool_name' => $toolName,
                'category_id' => 0,
                'category_name' => ""
            ]);
        }

        // Push Gratis Testen into array if available, or $skipNull is false
        if ($tool_gratis_testen_link_clickmeter_link_id > 0 || !$skipNull) {
            array_push($trackingLinks, (object) [
                'type' => TrackingLinkType::TEST,
                'link_id' => $tool_gratis_testen_link_clickmeter_link_id,
                'tracking_link' => get_field('tool_gratis_testen_link', $toolId),
                'tool_id' => $toolId,
                'tool_name' => $toolName,
                'category_id' => 0,
                'category_name' => ""
            ]);
        }

        foreach (Tool::init()->getToolCategories($toolId) as $category) {
            $term = get_term_by('id', $category['kategorie'], 'tooltyp');

            if (!$skipNull || (strlen($category['kategorie_zur_website_link']) > 0 && strlen($category['kategorie_zur_website_clickmeter_link_id']) > 0)) {
                array_push($trackingLinks, (object) [
                    'type' => TrackingLinkType::WEBSITE,
                    'link_id' => $category['kategorie_zur_website_clickmeter_link_id'],
                    'tracking_link' => $category['kategorie_zur_website_link'],
                    'tool_id' => $toolId,
                    'tool_name' => $toolName,
                    'category_id' => $category['kategorie'],
                    'category_name' => $term->name
                ]);
            }

            if (!$skipNull || (strlen($category['kategorie_preisubersicht_link']) > 0 && strlen($category['kategorie_preisubersicht_clickmeter_link_id']) > 0)) {
                array_push($trackingLinks, (object) [
                    'type' => TrackingLinkType::PRICE_OVERVIEW,
                    'link_id' => $category['kategorie_preisubersicht_clickmeter_link_id'],
                    'tracking_link' => $category['kategorie_preisubersicht_link'],
                    'tool_id' => $toolId,
                    'tool_name' => $toolName,
                    'category_id' => $category['kategorie'],
                    'category_name' => $term->name
                ]);
            }

            if (!$skipNull || (strlen($category['kategorie_tool_testen_link']) > 0 && strlen($category['kategorie_tool_testen_clickmeter_link_id']) > 0)) {
                array_push($trackingLinks, (object) [
                    'type' => TrackingLinkType::TEST,
                    'link_id' => $category['kategorie_tool_testen_clickmeter_link_id'],
                    'tracking_link' => $category['kategorie_tool_testen_link'],
                    'tool_id' => $toolId,
                    'tool_name' => $toolName,
                    'category_id' => $category['kategorie'],
                    'category_name' => $term->name
                ]);
            }
        }

        return $trackingLinks;
    }

    /**
     * Get tool categories tracking links
     * Old stuff logic, only refactored
     */
    public function categoriesLinks(int $toolId)
    {
        $trackingLinks = $this->links($toolId);

        // All tracking LInks are in one Array now. Make Sure we have only one Bid per Toolcategory!
        // unique_array wont work because of tool name&id so we use that loop to remove all duplicates => exactly one Bid per Tool/Category having betwenn 1 to 3 active Tracking Links:
        $taken = [];
        foreach ($trackingLinks as $key => $link) {
            // Old stuff logic: Get tracking links only where category_id > 0, because in toolanbieter-bids.php links are filtered by category
            if (!$link->category_id || in_array($link->category_id, $taken)) {
                unset($trackingLinks[$key]);
            } else {
                $taken[] = $link->category_id;
            }
        }

        foreach ($trackingLinks as $link) {
            // get current bidding for this link:
            $linkBids = Bid::init()->items([
                'active' => true,
                'tool' => $link->tool_id,
                'category' => $link->category_id
            ]);

            if (count($linkBids)) {
                foreach ($linkBids as $bid) {
                    $bidCosts = $bid->bid_kosten;
                    $bidId = $bid->ID;
                }

                $bidClicks = Click::init()->items(['bid' => $bidId]);

                foreach ($bidClicks as $click) {
                    // check if click is im current month!
                    if (date('Y-m', $click->timestamp_unix) === date('Y-m')) {
                        $bidCosts = $click->bid_kosten;
                    }
                }

                $link->bid_costs = $bidCosts;
                $link->bid_id = $bidId;
            }
        }

        return $trackingLinks;
    }

    /**
     * Update/Create ClickMeter link and set ClickMeter ID and tracking code for tool
     */
    public function saveLink(PostModel $tool, stdClass $link, string $url, int $campaignId)
    {
        $api = new ClickMeter;
        $toolCategories = Tool::init()->getToolCategories($tool->ID);

        // Update URL for given link in ClickMeter
        if ($link->link_id && $api->update((int) $link->link_id, $url, $campaignId)) {
            return $link->link_id;
        }

        // Create a new link in ClickMeter if not exist
        if ($datapoint = $api->create($campaignId, $url, $link->type, $tool->post_name, $link->category_name)) {
            $clickMeterLink = $api->item($datapoint['id']);

            if ($clickMeterLink) {
                if (!$link->category_id) {
                    // Update MAIN tool tracking link ID and Code in backend
                    $fields = $this->getToolTrackingLinkFieldsSelector($link->type);

                    update_field($fields->id, $clickMeterLink['id'], $tool->ID);
                    update_field($fields->trackingCode, $clickMeterLink['trackingCode'], $tool->ID);
                } else {
                    $fields = $this->getToolCategoryTrackingLinkFieldsSelector($link->type, $link->category_id, $toolCategories);

                    if (array_key_exists($link->category_id, $toolCategories)) {
                        // Update tool Category tracking link ID and Code in backend
                        update_sub_field($fields->id, $clickMeterLink['id'], $tool->ID);
                        update_sub_field($fields->trackingCode, $clickMeterLink['trackingCode'], $tool->ID);
                    } else {
                        // Add category to the "tool_kategorien" repeater and set tracking link ID and Code in backend
                        $idField = array_pop($fields->id);
                        $trackingCodeField = array_pop($fields->trackingCode);

                        $row = [
                            'kategorie' => $link->category_id,
                            $idField => $clickMeterLink['id'],
                            $trackingCodeField => $clickMeterLink['trackingCode']
                        ];

                        add_row('tool_kategorien', $row, $tool->ID);
                    }
                }

                return $clickMeterLink['id'];
            }
        }

        return false;
    }

    public function groupAndFetchClickMeterData(array $links)
    {
        $api = new ClickMeter;
        $trackingLinks = [];
        $labels = TrackingLinkType::all();

        foreach ($links as $link) {
            $link->typeLabel = $labels[$link->type];
            $link->clickMeter = $link->link_id && is_numeric($link->link_id)
                ? $api->item($link->link_id)
                : null;

            $trackingLinks[$link->category_id] ??= new stdClass;
            $trackingLinks[$link->category_id]->category_name = $link->category_name;

            $trackingLinks[$link->category_id]->links ??= [];
            $trackingLinks[$link->category_id]->links[] = $link;
        }

        return $trackingLinks;
    }

    public function getToolTrackingLinkFieldsSelector(string $type)
    {
        $fields = [];

        switch ($type) {
            case TrackingLinkType::PRICE_OVERVIEW:
                $fields = (object) [
                    'id' => 'tool_preisubersicht_clickmeter_link_id',
                    'trackingCode' => 'tool_preisubersicht'
                ];

                break;

            case TrackingLinkType::TEST:
                $fields = (object) [
                    'id' => 'tool_gratis_testen_link_clickmeter_link_id',
                    'trackingCode' => 'tool_gratis_testen_link'
                ];

                break;

            default:
                $fields = (object) [
                    'id' => 'toolanbieter_website_clickmeter_link_id',
                    'trackingCode' => 'zur_webseite'
                ];

                break;
        }

        return $fields;
    }

    public function getToolCategoryTrackingLinkFieldsSelector(string $type, int $categoryId, array $toolCategories)
    {
        $fields = [];

        $categoryRow = 0;
        foreach ($toolCategories as $category) {
            $categoryRow++;

            if ($category['kategorie'] == $categoryId) {
                break;
            }
        }

        switch ($type) {
            case TrackingLinkType::PRICE_OVERVIEW:
                $fields = (object) [
                    'id' => ['tool_kategorien', $categoryRow, 'kategorie_preisubersicht_clickmeter_link_id'],
                    'trackingCode' => ['tool_kategorien', $categoryRow, 'kategorie_preisubersicht_link']
                ];

                break;

            case TrackingLinkType::TEST:
                $fields = (object) [
                    'id' => ['tool_kategorien', $categoryRow, 'kategorie_tool_testen_clickmeter_link_id'],
                    'trackingCode' => ['tool_kategorien', $categoryRow, 'kategorie_tool_testen_link']
                ];

                break;

            default:
                $fields = (object) [
                    'id' => ['tool_kategorien', $categoryRow, 'kategorie_zur_website_clickmeter_link_id'],
                    'trackingCode' => ['tool_kategorien', $categoryRow, 'kategorie_zur_website_link']
                ];

                break;
        }

        return $fields;
    }
}
