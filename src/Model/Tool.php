<?php

namespace OMT\Model;

use OMT\Enum\CategoryType;
use OMT\Enum\ToolPricePlan;
use OMT\Enum\TrackingLinkType;
use OMT\Model\Datahost\Category;
use OMT\Model\Datahost\MarketingTool;
use OMT\Model\Datahost\ToolCategory;
use OMT\Model\Datahost\ToolDetail;
use OMT\Services\ArraySort;
use OMT\Model\Datahost\ToolTrackingLink;
use stdClass;
use WP_Post;

class Tool extends PostModel
{
    protected $postType = 'tool';

    /**
     * Get alternatives tools related to the primary category of the given tool
     *
     * @return array
     */
    public function alternatives($toolId)
    {
        static $alternatives = [];

        if (!array_key_exists($toolId, $alternatives)) {
            $primaryCategoryId = get_post_meta($toolId, '_yoast_wpseo_primary_tooltyp', true);

            $alternatives[$toolId] = !$primaryCategoryId
                ? []
                : get_posts([
                    'numberposts' => -1,
                    'post_type' => 'tool',
                    'exclude' => [$toolId],
                    'tax_query' => [[
                        'taxonomy' => 'tooltyp',
                        'field' => 'term_id',
                        'terms' => $primaryCategoryId
                    ]]
                ]);
        }

        return $alternatives[$toolId];
    }

    public function toolsWithDisabledAlternatives(int $limit = 10)
    {
        return $this->items([
            'alternatives' => false,
            'isToolPage' => false
        ], ['count' => $limit]);
    }

    /**
     * Get tools pages type
     * If we have 1 or more ZEILEN, this is going to be treated as a Tool PAGE
     *
     * @return array
     */
    public function toolsPages()
    {
        return $this->items([
            'isToolPage' => true
        ]);
    }

    /**
     * Get tools linked to an author
     *
     * @param int $authorId
     * @param string $authorType report|applicationTips
     *
     * @return array
     */
    public function authorTools(int $authorId, string $authorType = 'report')
    {
        $items = $this->items([
            'isToolPage' => false,
            $authorType == 'report' ? 'reportAuthor' : 'applicationTipsAuthor' => $authorId
        ]);

        return $this->withExtraData($items, ['logo']);
    }

    /**
     * Get tool active categories from ACF field "tool_kategorien"
     *
     * @return array [category_id => category]
     */
    public function getToolCategoriesWithActiveLinks(int $toolId)
    {
        $categories = [];

        // Functionality of active categories/links got from /Crons/SendToolsMonthlyStats.php
        foreach ($this->getToolCategories($toolId) as $id => $category) {
            if (
                (strlen($category['kategorie_zur_website_link']) > 0 && strlen($category['kategorie_zur_website_clickmeter_link_id']) > 0) ||
                (strlen($category['kategorie_preisubersicht_link']) > 0 && strlen($category['kategorie_preisubersicht_clickmeter_link_id']) > 0) ||
                (strlen($category['kategorie_tool_testen_link']) > 0 && strlen($category['kategorie_tool_testen_clickmeter_link_id']) > 0)
            ) {
                $category['term'] = get_term_by('id', $id, 'tooltyp');
                $categories[$id] = $category;
            }
        }

        return $categories;
    }

    /**
     * Get tool categories from ACF field "tool_kategorien"
     *
     * @return array [category_id => category]
     */
    public function getToolCategories(int $toolId)
    {
        $categories = [];

        foreach ((array) get_field('tool_kategorien', $toolId) as $category) {
            $categories[$category['kategorie']] = $category;
        }

        return array_filter($categories);
    }

    /**
     * Get preview texts for categories from ACF field "vorschautext_nach_kategorie"
     *
     * @return array [category_id => preview text]
     */
    public function getCategoriesPreviewTexts(int $toolId)
    {
        $previewTexts = [];

        foreach ((array) get_field('vorschautext_nach_kategorie', $toolId) as $previewText) {
            $previewTexts[$previewText['toolkategorie']] = (object) [
                'category_id' => $previewText['toolkategorie'],
                'preview_text' => $previewText['vorschautext_dieser_kategorie']
            ];
        }

        return $previewTexts;
    }

    protected function filter(array $filter = [])
    {
        $query = parent::filter($filter);

        if (array_key_exists('alternatives', $filter)) {
            if ($filter['alternatives']) {
                array_push($query['meta_query'], [
                    'key' => 'alternativseite_anzeigen',
                    'value' => 1
                ]);
            } else {
                array_push($query['meta_query'], [
                    'relation' => 'OR',
                    [
                        'key' => 'alternativseite_anzeigen',
                        'value' => 0
                    ],
                    [
                        'key' => 'alternativseite_anzeigen',
                        'compare' => 'NOT EXISTS'
                    ]
                ]);
            }
        }

        if (array_key_exists('isToolPage', $filter)) {
            $isToolPageQuery = [
                'key' => 'zeilen',
                'value' => 0
            ];

            if ($filter['isToolPage']) {
                // If we have 1 or more ZEILEN, this is going to be treated as a Tool PAGE
                $isToolPageQuery['compare'] = '>';
            } else {
                $isToolPageQuery['compare'] = '<=';
            }

            array_push($query['meta_query'], $isToolPageQuery);
        }

        if (array_key_exists('reportAuthor', $filter)) {
            array_push($query['meta_query'], [
                'key' => 'autor',
                'value' => (int) $filter['reportAuthor']
            ]);
        }

        if (array_key_exists('applicationTipsAuthor', $filter)) {
            array_push($query['meta_query'], [
                'key' => 'anwendungstipps_autor',
                'value' => (int) $filter['applicationTipsAuthor']
            ]);
        }

        return $query;
    }

    /**
     * Convert an array of WP_Post Tools to format as in .json files
     *
     * @return array
     */
    public function toJson(array $tools, $sort = 'rating')
    {
        $items = [];

        foreach ($tools as $tool) {
            $logofield = get_field('logo', $tool->ID);
            $vorschautext = get_field('vorschautext', $tool->ID);

            if (empty($vorschautext)) {
                $vorschautext_nach_kategorie = get_field('vorschautext_nach_kategorie', $tool->ID);

                if (is_array($vorschautext_nach_kategorie)) {
                    $vorschautext = $vorschautext_nach_kategorie[0]['vorschautext_dieser_kategorie'];
                }
            }

            array_push($items, [
                'ID' => $tool->ID,
                '$post_status' => 'public',
                '$title' => $tool->post_title,
                '$link' => get_the_permalink($tool->ID),
                '$logo' => $logofield['url'],
                '$logo_350' => $logofield['sizes']['350-180'],
                '$tool_vorschautitel' => get_field('vorschautitel_fur_index', $tool->ID),
                '$tool_vorschautext' => $vorschautext,
                '$vorschautext_nach_kategorie' => $vorschautext,
                '$tool_kategorien' => '',
                '$toolanbieter' => get_field('toolanbieter', $tool->ID),
                '$anzahl_bewertungen' => get_field('anzahl_bewertungen', $tool->ID) ?: 0,
                '$wertung_gesamt' => get_field('gesamt', $tool->ID),
                '$clubstimmen' => get_field('club_stimmenanzahl', $tool->ID) ?: 0
            ]);
        }

        return $this->sortJson($items, $sort);
    }

    public function withExtraData(array $tools = [], array $fields = [])
    {
        foreach ($tools as $tool) {
            $tool->extra ??= new stdClass;

            $tool->extra->logo = $this->getExtraFieldValue($fields, 'logo', 'logo', $tool->ID);
            $tool->extra->report_title = $this->getExtraFieldValue($fields, 'report_title', 'titelbild_overlay_h1', $tool->ID);
            $tool->extra->report_content = $this->getExtraFieldValue($fields, 'report_content', 'inhalt', $tool->ID);
            $tool->extra->application_tips = $this->getExtraFieldValue($fields, 'application_tips', 'anwendungstipps', $tool->ID);
        }

        return $tools;
    }

    /**
     * Get worth of the tool when "Tool Kategorien" is filled
     * If "$buttons_anzeigen" is enabled worth will be equal to "1"
     *
     * @param array $tool format as in .json files
     *
     * @return bool
     */
    public function worth(bool $showButtons, $balance, array $acfCategories, $currentCategory)
    {
        if ($showButtons && $balance > 0) {
            foreach ($acfCategories as $category) {
                if ($category['kategorie'] == $currentCategory && $category['gebot'] > 0) {
                    return 100*$category['gebot'];
                }
            }
        }

        return $showButtons ? 1 : 0;
    }

    public function sync(WP_Post $post)
    {
        $model = MarketingTool::init();

        $logo = get_field('logo', $post->ID);
        $previewTitle = get_field('vorschautitel_fur_index', $post->ID);
        $showButtons = get_field('buttons_anzeigen', $post->ID) ? 1 : 0;
        $worth = floatval(get_field('wert', $post->ID)) ?: 0;
        $balance = get_field('guthaben', $post->ID) ?: 0;
        $pricePlans = array_filter((array) get_field('filter_preis', $post->ID)) ?: ['kostenlos'];
        $clubRating = get_field('club_stimmenanzahl', $post->ID) ?: 0;
        $previewText = get_field('vorschautext', $post->ID) ?: null;

        if (empty($previewTitle)) {
            $previewTitle = get_the_title($post);
        }

        if (strlen($previewTitle) > 60) {
            $previewTitle = substr($previewTitle, 0, 60) . '...';
        }

        if ($balance <= 0) {
            $worth = 0;
        }

        $itemId = $model->store([
            'id' => $post->ID,
            'title' => get_the_title($post),
            'status' => get_post_status($post),
            'url' => get_the_permalink($post),
            'logo' => $logo ? $logo['url'] : null,
            'logo_350' => $logo ? $logo['sizes']['350-180'] : null, // TODO: test if used
            'logo_550' => $logo ? $logo['sizes']['550-290'] : null, // TODO: test if used
            'preview_title' => $previewTitle,
            'preview_text' => $previewText,
            'tool_provider' => get_field('toolanbieter', $post->ID) ?: null,
            'show_buttons' => $showButtons,
            'worth' => $worth,
            'balance' => $balance,
            'club_rating' => $clubRating,
            'reviews_count' => get_field('anzahl_bewertungen', $post->ID) ?? 0,
            'rating' => get_field('gesamt', $post->ID) ?? 0,
            'rating_user_friendliness' => get_field('benutzerfreundlichkeit', $post->ID) ?? 0,
            'rating_customer_service' => get_field('kundenservice', $post->ID) ?? 0,
            'rating_features' => get_field('funktionen', $post->ID) ?? 0,
            'rating_price_performance' => get_field('preis-leistungs-verhaltnis', $post->ID) ?? 0,
            'rating_recommendation' => get_field('wahrscheinlichkeit_weiterempfehlung', $post->ID) ?? 0,
            'has_review' => get_field('filter_testbericht', $post->ID) ? 1 : 0,
            'has_free_plan' => in_array(ToolPricePlan::FREE, $pricePlans) ? 1 : 0,
            'has_paid_plan' => in_array(ToolPricePlan::PAID, $pricePlans) ? 1 : 0,
            'has_test_plan' => in_array(ToolPricePlan::TEST, $pricePlans) ? 1 : 0,
            'has_trial_plan' => in_array(ToolPricePlan::TRIAL, $pricePlans) ? 1 : 0,
            'website_button_label' => get_field('toolanbieter_website_optionales_alternativlabel', $post->ID) ?: null,
            'price_button_label' => get_field('toolanbieter_preise_optionales_alternativlabel', $post->ID) ?: null,
            'test_button_label' => get_field('toolanbieter_testen_optionales_alternativlabel', $post->ID) ?: null
        ]);

        if ($itemId) {
            $categories = array_filter((array) get_the_terms($post->ID, 'tooltyp'));
            $acfCategories = array_filter((array) get_field('tool_kategorien', $post->ID));
            $clubRatings = array_filter((array) get_field('club_stimmenanzahl_nach_kategorien', $post->ID));
            $previewTexts = array_filter((array) get_field('vorschautext_nach_kategorie', $post->ID));

            $this->syncCategories($itemId, $worth, $clubRating, $previewText, $showButtons, $balance, $acfCategories, $categories, $clubRatings, $previewTexts);
            $this->syncTrackingLinks($itemId);
            $this->syncCategoriesTrackingLinks($itemId, $acfCategories);

            // Sync default details
            $this->syncDetails($itemId, 0, (array) get_field('tool_details', $post->ID));

            // Sync details per category
            foreach (array_filter((array) get_field('tool_details_by_categories', $post->ID)) as $categoryDetails) {
                $this->syncDetails($itemId, (int) $categoryDetails['category'], (array) $categoryDetails['details']);
            }

            return true;
        }

        return false;
    }

    protected function sortJson(array $tools, $sort = 'rating')
    {
        switch ($sort) {
            // Sort by the rating of club members reviews
            case 'club_rating':
                ArraySort::toolsByClubRating($tools);
                break;

            // Sort alphabetical by the title
            case 'alphabetical':
                ArraySort::alphabetical($tools, '$tool_vorschautitel');
                break;

            // Sort by the rating of reviews
            case 'rating':
            default:
                ArraySort::toolsByRating($tools);
                break;
        }

        return $tools;
    }

    protected function syncCategories(int $id, $worth, $clubRating, $previewText, $showButtons, $balance, array $acfCategories = [], array $categories = [], array $clubRatings = [], array $previewTexts = [])
    {
        $model = Category::init();
        $relationshipModel = ToolCategory::init();

        // Delete old "tool_category" relationship
        $relationshipModel->delete(['tool_id' => $id]);

        // Save or update new categories and create new "tool_category" relationship
        foreach ($categories as $category) {
            $result = $model->store([
                'id' => $category->term_id,
                'name' => $category->name,
                'slug' => $category->slug,
                'type' => CategoryType::TOOL
            ]);

            if ($result) {
                $categoryClubRating = $clubRating;
                $categoryPreviewText = $previewText;

                if (count($acfCategories)) {
                    $worth = $this->worth((bool) $showButtons, $balance, $acfCategories, $category->term_id);
                }

                foreach ($clubRatings as $value) {
                    if ($category->term_id == $value['kategorie']) {
                        $categoryClubRating = $value['anzahl_clubstimmen'];
                        break;
                    }
                }

                foreach ($previewTexts as $value) {
                    if ($category->term_id == $value['toolkategorie']) {
                        $categoryPreviewText = $value['vorschautext_dieser_kategorie'];
                        break;
                    }
                }

                $relationshipModel->store([
                    'tool_id' => $id,
                    'category_id' => $category->term_id,
                    'worth' => $worth,
                    'club_rating' => $categoryClubRating,
                    'preview_text' => $categoryPreviewText
                ], ['timestamps' => false]);
            }
        }

        return true;
    }

    protected function syncDetails(int $toolId, int $categoryId, array $details = [])
    {
        $model = ToolDetail::init();

        // Delete old tool details
        $model->delete([
            'tool_id' => $toolId,
            'category_id' => $categoryId
        ]);

        $order = 0;
        foreach (array_filter($details) as $detail) {
            $model->store([
                'tool_id' => $toolId,
                'category_id' => $categoryId,
                'detail' => $detail['detail'],
                'order' => ++$order
            ], ['timestamps' => false]);
        }

        return true;
    }

    protected function syncTrackingLinks(int $toolId)
    {
        $model = ToolTrackingLink::init();

        // Save "website" tracking link
        $item = $model->item([
            'tool' => $toolId,
            'category' => 0,
            'type' => TrackingLinkType::WEBSITE
        ]);

        $model->store([
            'id' => $item ? $item->id : 0,
            'tool_id' => $toolId,
            'category_id' => 0,
            'type' => TrackingLinkType::WEBSITE,
            'clickmeter_id' => get_field('toolanbieter_website_clickmeter_link_id', $toolId) ?: null,
            'clickmeter_url' => get_field('zur_webseite', $toolId) ?: null
        ]);

        // Save "prices" tracking link
        $item = $model->item([
            'tool' => $toolId,
            'category' => 0,
            'type' => TrackingLinkType::PRICE_OVERVIEW
        ]);

        $model->store([
            'id' => $item ? $item->id : 0,
            'tool_id' => $toolId,
            'category_id' => 0,
            'type' => TrackingLinkType::PRICE_OVERVIEW,
            'clickmeter_id' => get_field('tool_preisubersicht_clickmeter_link_id', $toolId) ?: null,
            'clickmeter_url' => get_field('tool_preisubersicht', $toolId) ?: null
        ]);

        // Save "test" tracking link
        $item = $model->item([
            'tool' => $toolId,
            'category' => 0,
            'type' => TrackingLinkType::TEST
        ]);

        $model->store([
            'id' => $item ? $item->id : 0,
            'tool_id' => $toolId,
            'category_id' => 0,
            'type' => TrackingLinkType::TEST,
            'clickmeter_id' => get_field('tool_gratis_testen_link_clickmeter_link_id', $toolId) ?: null,
            'clickmeter_url' => get_field('tool_gratis_testen_link', $toolId) ?: null
        ]);

        return true;
    }

    protected function syncCategoriesTrackingLinks(int $toolId, array $categories = [])
    {
        $model = ToolTrackingLink::init();

        foreach ($categories as $category) {
            // Save category "website" tracking link
            $item = $model->item([
                'tool' => $toolId,
                'category' => $category['kategorie'],
                'type' => TrackingLinkType::WEBSITE
            ]);

            $model->store([
                'id' => $item ? $item->id : 0,
                'tool_id' => $toolId,
                'category_id' => $category['kategorie'],
                'type' => TrackingLinkType::WEBSITE,
                'clickmeter_id' => $category['kategorie_zur_website_clickmeter_link_id'] ?: null,
                'clickmeter_url' => $category['kategorie_zur_website_link'] ?: null
            ]);

            // Save category "prices" tracking link
            $item = $model->item([
                'tool' => $toolId,
                'category' => $category['kategorie'],
                'type' => TrackingLinkType::PRICE_OVERVIEW
            ]);

            $model->store([
                'id' => $item ? $item->id : 0,
                'tool_id' => $toolId,
                'category_id' => $category['kategorie'],
                'type' => TrackingLinkType::PRICE_OVERVIEW,
                'clickmeter_id' => $category['kategorie_preisubersicht_clickmeter_link_id'] ?: null,
                'clickmeter_url' => $category['kategorie_preisubersicht_link'] ?: null
            ]);

            // Save category "test" tracking link
            $item = $model->item([
                'tool' => $toolId,
                'category' => $category['kategorie'],
                'type' => TrackingLinkType::TEST
            ]);

            $model->store([
                'id' => $item ? $item->id : 0,
                'tool_id' => $toolId,
                'category_id' => $category['kategorie'],
                'type' => TrackingLinkType::TEST,
                'clickmeter_id' => $category['kategorie_tool_testen_clickmeter_link_id'] ?: null,
                'clickmeter_url' => $category['kategorie_tool_testen_link'] ?: null
            ]);
        }

        return true;
    }
}
