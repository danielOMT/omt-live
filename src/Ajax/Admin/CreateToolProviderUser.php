<?php

namespace OMT\Ajax\Admin;

use OMT\Ajax\Ajax;
use OMT\API\ClickMeter;
use OMT\Model\Datahost\Bid;
use OMT\Model\Datahost\Budget;
use OMT\Model\Datahost\Deposit;
use OMT\Model\Datahost\TrackingLinksHistory;
use OMT\Model\PostModel;
use OMT\Model\Tool;
use OMT\Model\User;
use OMT\Services\Date;
use OMT\Services\Response;
use OMT\Services\Roles;
use OMT\Services\ToolTrackingLinks;
use stdClass;

class CreateToolProviderUser extends Ajax
{
    const BID_PRICE = 2;

    public function handle()
    {
        if (!Roles::isAdministrator()) {
            Response::jsonError('Access denied', [], 403);
        }

        $userModel = User::init();
        $bidModel = Bid::init();

        $tools = (array) $_POST['tools'];
        $toolId = reset($tools);

        if (!$toolId) {
            Response::jsonError('Bitte zugewiesenes tool auswählen');
        }

        $tool = getPost($toolId);

        $userId = $userModel->create([
            'user_login' => $tool->post_name,
            'role' => 'um_toolanbieter',
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'user_email' => $_POST['email'],
            'user_pass' => $_POST['password'],
            'firma' => $_POST['firma'],
            'assignedTools' => [$tool->ID]
        ]);

        if (!$userId) {
            Response::jsonError($userModel->renderErrors());
        }

        // Approve newly created user
        um_fetch_user($userId);
        UM()->user()->approve();

        // Set start deposit
        if ($_POST['deposit'] > 0) {
            Deposit::init()->store([
                'user_id' => $userId,
                'betrag' => floatval($_POST['deposit']),
                'woocommerce_order_id' => 0
            ], ['timestamps' => false]);
        }

        // Create/Update ClickMeter URL's
        $this->saveTrackingLinks((array) $_POST['tracking_links'], $tool, $userId);

        if ($_POST['activate_buttons']) {
            // Set the Budgetlimit/Monat to the entered deposit
            Budget::init()->store([
                'unix_timestamp' => Date::get()->getTimestamp(),
                'user_id' => $userId,
                'user_ip' => $_SERVER['REMOTE_ADDR'],
                'tool_id' => $tool->ID,
                'toolkategorie_id' => 0,
                'budget' => floatval($_POST['deposit'])
            ], ['timestamps' => false]);

            // Set the Bid to 2€/Click for all tool categories
            foreach (Tool::init()->getToolCategories($tool->ID) as $category) {
                if (!$bidModel->set($tool->ID, $category['kategorie'], self::BID_PRICE, $userId, $_SERVER['REMOTE_ADDR'])) {
                    Response::jsonError($bidModel->renderErrors());
                }
            }
        }

        $this->updateCategoriesPreviewTexts($tool);

        Response::json([], 'User has been successfully created. It will appear in the Toolanbieter section in a few minutes after the Cronjob has run');
    }

    protected function saveTrackingLinks(array $trackingLinks, PostModel $tool, int $userId)
    {
        $service = new ToolTrackingLinks;
        $links = $service->links($tool->ID, false);

        $campaignId = $this->getCampaignId($tool);

        foreach ($this->filterTrackingLinks($trackingLinks) as $trackingLink) {
            if (!$service->saveLink($tool, $this->trackingLinkObject($links, $trackingLink), $trackingLink['url'], $campaignId)) {
                Response::jsonError('Fehler beim Speichern der Tracking-URL');
            }

            TrackingLinksHistory::init()->store([
                'tool_id' => $tool->ID,
                'url' => $trackingLink['url'],
                'action' => TrackingLinksHistory::ACTION_UPDATED,
                'user_id' => $userId,
                'user_ip' => $_SERVER['REMOTE_ADDR']
            ]);
        }
    }

    protected function trackingLinkObject(array $links, array $requestLink)
    {
        $item = reset(array_filter($links, fn ($link) => $link->type == $requestLink['type'] && $link->category_id == $requestLink['category_id']));

        if (!$item) {
            $item = new stdClass;
            $term = get_term_by('id', $requestLink['category_id'], 'tooltyp');

            $item->link_id = 0;
            $item->type = $requestLink['type'];
            $item->category_id = $requestLink['category_id'];
            $item->category_name = $term->name;
        }

        return $item;
    }

    protected function getCampaignId($tool)
    {
        $api = new ClickMeter;

        $campaigns = $api->campaigns([
            'status' => ClickMeter::CAMPAIGN_ACTIVE_STATUS,
            'search' => $tool->post_name
        ]);

        $campaign = count($campaigns)
            ? reset($campaigns)
            : $api->createCampaign($tool->post_name);

        return (int) $campaign['id'];
    }

    protected function updateCategoriesPreviewTexts(PostModel $tool)
    {
        $previewText = get_field('vorschautext', $tool->ID);
        $categories = get_the_terms($tool->ID, 'tooltyp');
        $categoriesPreviewText = Tool::init()->getCategoriesPreviewTexts($tool->ID);

        foreach ($categories as $category) {
            if (!array_key_exists($category->term_id, $categoriesPreviewText)) {
                add_row(
                    'vorschautext_nach_kategorie',
                    [
                        'toolkategorie' => $category->term_id,
                        'vorschautext_dieser_kategorie' => $previewText
                    ],
                    $tool->ID
                );
            } elseif (empty($categoriesPreviewText[$category->term_id]->preview_text)) {
                update_sub_field($this->getCategoryPreviewTextFieldSelector($categoriesPreviewText, $category->term_id), $previewText, $tool->ID);
            }
        }
    }

    protected function filterTrackingLinks(array $links)
    {
        return array_filter($links, fn ($link) => !empty($link['url']) && filter_var($link['url'], FILTER_VALIDATE_URL));
    }

    protected function getCategoryPreviewTextFieldSelector(array $categories, int $categoryId)
    {
        $index = 0;
        foreach ($categories as $category) {
            $index++;

            if ($category->category_id == $categoryId) {
                break;
            }
        }

        return ['vorschautext_nach_kategorie', $index, 'vorschautext_dieser_kategorie'];
    }

    public function enqueueScripts()
    {
        wp_enqueue_script('create-tool-provider-user', get_template_directory_uri() . '/library/js/custom/create-tool-provider-user.js', ['jquery'], '1.0.0', true);
        wp_localize_script('create-tool-provider-user', $this->getAction(), [
            'nonce' => wp_create_nonce($this->getAction()),
            'ajax_url' => admin_url('admin-ajax.php')
        ]);
    }

    protected function getAction()
    {
        return 'omt_create_tool_provider_user';
    }
}
