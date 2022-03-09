<?php

namespace OMT\Ajax;

use Exception;
use OMT\API\ClickMeter;
use OMT\Model\Datahost\TrackingLinksHistory;
use OMT\Model\Tool;
use OMT\Model\User;
use OMT\Services\ToolTrackingLinks;

class DeleteToolTrackingLink extends Ajax
{
    public function handle()
    {
        try {
            $toolId = (int) $_POST['tool_id'];
            $categoryId = (int) $_POST['category_id'];
            $type = $_POST['type'];

            $api = new ClickMeter;
            $service = new ToolTrackingLinks;
            $userId = get_current_user_id();
            $userTools = User::init()->tools($userId);

            // Check if user is allowed to delete tool link
            if (!$toolId || count(array_filter($userTools, fn ($tool) => $tool->ID == $toolId)) == 0) {
                throw new Exception("Access denied", 403);
            }

            $tool = getPost($toolId);
            $toolCategories = Tool::init()->getToolCategories($tool->ID);

            // Get tool tracking link by type and category
            $trackingLink = reset(array_filter(
                $service->links($tool->ID),
                fn ($link) => $link->type == $type && $link->category_id == $categoryId
            ));

            if (!$trackingLink) {
                throw new Exception("Fehler. Tracking-Link nicht gefunden", 422);
            }

            $clickMeterLink = $api->item($trackingLink->link_id);

            if ($api->delete($trackingLink->link_id)) {
                if (!$trackingLink->category_id) {
                    // Set MAIN tool tracking links ID and TrackingCode to empty in backend
                    $fields = $service->getToolTrackingLinkFieldsSelector($type);

                    update_field($fields->id, '', $tool->ID);
                    update_field($fields->trackingCode, '', $tool->ID);
                } else {
                    // Set tool Category tracking links ID and TrackingCode to empty in backend
                    $fields = $service->getToolCategoryTrackingLinkFieldsSelector($type, $trackingLink->category_id, $toolCategories);

                    update_sub_field($fields->id, '', $tool->ID);
                    update_sub_field($fields->trackingCode, '', $tool->ID);
                }
            } else {
                // Throw error if it's not "Specified datapoint does not exist" error
                foreach ($api->getErrors() as $error) {
                    if ($error['code'] != "0013") {
                        throw new Exception("Fehler beim löschen der Tracking-URL", 422);
                    }
                }
            }

            TrackingLinksHistory::init()->store([
                'tool_id' => $tool->ID,
                'category_id' => $trackingLink->category_id,
                'url' => $clickMeterLink['typeTL']['url'],
                'action' => TrackingLinksHistory::ACTION_DELETED,
                'user_id' => $userId,
                'user_ip' => $_SERVER['REMOTE_ADDR']
            ]);

            die(json_encode([
                'error' => false,
                'message' => 'Die Tracking-URL wurde gelöscht'
            ]));
        } catch (Exception $ex) {
            die(json_encode([
                'error' => true,
                'message' => $ex->getMessage()
            ]));
        }
    }

    public function enqueueScripts()
    {
        wp_enqueue_script('alpinejs', get_template_directory_uri() . '/library/js/libs/alpine.min.js', ['alpine-modal']);
        wp_enqueue_script('alpine-modal', get_template_directory_uri() . '/library/js/core/modal.js');
        wp_enqueue_script('delete-tool-tracking-link', get_template_directory_uri() . '/library/js/custom/delete-tool-tracking-link.js', ['jquery'], '1.0.0', true);

        wp_localize_script('delete-tool-tracking-link', $this->getAction(), [
            'nonce' => wp_create_nonce($this->getAction()),
            'ajax_url' => admin_url('admin-ajax.php')
        ]);
    }

    protected function getAction()
    {
        return 'omt_delete_tool_tracking_link';
    }
}
