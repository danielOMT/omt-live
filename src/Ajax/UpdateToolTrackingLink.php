<?php

namespace OMT\Ajax;

use Exception;
use OMT\API\ClickMeter;
use OMT\Model\Datahost\TrackingLinksHistory;
use OMT\Model\User;
use OMT\Services\ToolTrackingLinks;

class UpdateToolTrackingLink extends Ajax
{
    public function handle()
    {
        try {
            $toolId = (int) $_POST['tool_id'];
            $categoryId = (int) $_POST['category_id'];
            $type = $_POST['type'];
            $url = $_POST['url'];

            $service = new ToolTrackingLinks;
            $userId = get_current_user_id();
            $userTools = User::init()->tools($userId);

            // Check if user is allowed to change tool link
            if (!$toolId || count(array_filter($userTools, fn ($tool) => $tool->ID == $toolId)) == 0) {
                throw new Exception("Access denied", 403);
            }

            if (empty($url)) {
                throw new Exception("Bitte URL eingeben", 422);
            }

            $tool = getPost($toolId);

            // Get tool tracking link by type and category
            $trackingLink = reset(array_filter(
                $service->links($tool->ID, false),
                fn ($link) => $link->type == $type && $link->category_id == $categoryId
            ));

            if (!$trackingLink) {
                throw new Exception("Fehler. Tracking-Link nicht gefunden", 422);
            }

            // Check if URL is not the same
            if ($trackingLink->link_id) {
                $clickMeterLink = (new ClickMeter)->item($trackingLink->link_id);

                if ($clickMeterLink && $clickMeterLink['typeTL']['url'] == $url) {
                    throw new Exception("Bitte geben Sie eine neue URL ein", 422);
                }
            }

            if (!$service->saveLink($tool, $trackingLink, $url, $this->getCampaignId($tool))) {
                throw new Exception("Fehler beim Speichern der Tracking-URL", 422);
            }

            TrackingLinksHistory::init()->store([
                'tool_id' => $tool->ID,
                'category_id' => $trackingLink->category_id,
                'url' => $url,
                'action' => TrackingLinksHistory::ACTION_UPDATED,
                'user_id' => $userId,
                'user_ip' => $_SERVER['REMOTE_ADDR']
            ]);

            die(json_encode([
                'error' => false,
                'message' => 'Die Tracking-URL wurde aktualisiert'
            ]));
        } catch (Exception $ex) {
            die(json_encode([
                'error' => true,
                'message' => $ex->getMessage()
            ]));
        }
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

    public function enqueueScripts()
    {
        wp_enqueue_script('alpinejs', get_template_directory_uri() . '/library/js/libs/alpine.min.js', ['alpine-modal']);
        wp_enqueue_script('alpine-modal', get_template_directory_uri() . '/library/js/core/modal.js');
        wp_enqueue_script('update-tool-tracking-link', get_template_directory_uri() . '/library/js/custom/update-tool-tracking-link.js', ['jquery'], '1.0.0', true);

        wp_localize_script('update-tool-tracking-link', $this->getAction(), [
            'nonce' => wp_create_nonce($this->getAction()),
            'ajax_url' => admin_url('admin-ajax.php')
        ]);
    }

    protected function getAction()
    {
        return 'omt_update_tool_tracking_link';
    }
}
