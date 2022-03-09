<?php

namespace OMT\Ajax;

use OMT\Enum\ToolPricePlan;
use OMT\Model\Datahost\MarketingTool;
use OMT\Model\PostModel;
use OMT\Services\Response;
use OMT\View\ToolView;

class LoadTools extends Ajax
{
    public function handle()
    {
        $requestFilters = $_GET['filter'];
        $type = $_GET['type'];
        $category = $_GET['category'];

        switch ($_GET['order']) {
            case 'reviews_count':
                $order = ['reviews_count' => 'DESC'];
                break;

            case 'rating':
                $order = ['rating' => 'DESC'];
                break;

            case 'alphabetical':
                $order = ['preview_title' => 'ASC'];
                break;

            case 'club_rating':
                $clubRatingColumn = ($type == 'kategorie' && $category) ? 't2c.`club_rating`' : 'club_rating';
                $order = [$clubRatingColumn => 'DESC'];
                break;

            default:
                // Default sorting is by Sponsored/Worth/$wert (=> Rating => Count of reviews => Alphabetical)
                $worthColumn = ($type == 'kategorie' && $category) ? 't2c.`worth`' : 'worth';
                $order = [$worthColumn => 'DESC', 'rating' => 'DESC', 'reviews_count' => 'DESC', 'preview_title' => 'ASC'];
        }

        $filters = [
            // Fetch published and private tools, logic migrated from JSON solution
            'status' => [PostModel::POST_STATUS_PUBLISH, PostModel::POST_STATUS_PRIVATE]
        ];

        $options = [
            'order' => $order,
            'with' => ['categories', 'tracking_links', 'details']
        ];

        if (in_array($requestFilters['price'], ToolPricePlan::keys())) {
            $filters['plan'] = $requestFilters['price'];
        }

        if (isset($requestFilters['review']) && $requestFilters['review']) {
            $filters['hasReview'] = true;
        }

        $templateVars = [
            'displayType' => $type,
            'category' => 0
        ];

        if ($type == 'kategorie' && $category) {
            $filters['category'] = $category;
            $templateVars['category'] = $category;
        }

        if ($type == 'tabelle') {
            // Get all tools assigned to the "Tooltabelle" post type
            $filters['id'] = array_map(fn ($item) => $item['tool']->ID, (array) get_field('tools_auswahlen', $_GET['table']));
        }

        $templateVars['tools'] = $filters['category'] || $filters['id']
            ? MarketingTool::init()->items($filters, $options)
            : [];

        Response::json([
            'content' => ToolView::loadTemplate('ajax-items', $templateVars)
        ]);
    }

    public function enqueueScripts()
    {
        wp_enqueue_script('alpine-app', get_template_directory_uri() . '/library/js/app.js', [], 'c.1.0.4', true);
        wp_localize_script('alpine-app', $this->getAction(), [
            'nonce' => wp_create_nonce($this->getAction()),
            'url' => admin_url('admin-ajax.php')
        ]);
    }

    protected function getAction()
    {
        return 'omt_load_tools';
    }
}
