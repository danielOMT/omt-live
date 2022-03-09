<?php

namespace OMT\Job\Sync;

use OMT\Job\Job;
use OMT\Model\Datahost\ToolReview as DatahostToolReview;
use OMT\Model\ToolReview;
use OMT\Services\Roles;
use WP_Post;

class ToolReviewsSync extends Job
{
    public function __construct()
    {
        // Sync tool when the corresponding post has been saved
        // Initialize hook later (priority = 15) to have all the actual data from other plugins like ACF
        add_action('save_post', [$this, 'save'], 15, 3);

        // Sync deletion (destroy) when the corresponding post has been deleted
        add_action('deleted_post', [$this, 'destroy'], 15, 2);

        // Sync all tool reviews manually running /wp-admin/admin-ajax.php?action=sync_all_tool_reviews
        add_action('wp_ajax_sync_all_tool_reviews', [$this, 'saveAll']);
    }

    public function save($postId, WP_Post $post, bool $update)
    {
        if (defined('DOING_AJAX') && DOING_AJAX) {
            return;
        }

        if ($post->post_type !== ToolReview::init()->getPostTypeName()) {
            return;
        }

        if (wp_is_post_revision($post)) {
            return;
        }

        if (isset($post->post_status) && $post->post_status == 'auto-draft') {
            return;
        }

        // Do not save drafts because of the error when submitting a new review on front
        if (isset($post->post_status) && $post->post_status == ToolReview::POST_STATUS_DRAFT) {
            return;
        }

        ToolReview::init()->sync($post);
    }

    public function destroy($postid, WP_Post $post)
    {
        if (defined('DOING_AJAX') && DOING_AJAX) {
            return;
        }

        if ($post->post_type !== ToolReview::init()->getPostTypeName()) {
            return;
        }

        DatahostToolReview::init()->destroy($post->ID);
    }

    public function saveAll()
    {
        if (!Roles::isAdministrator()) {
            return false;
        }

        $model = ToolReview::init();

        // Save only published and private tools, logic migrated from JSON solution
        // Do not save drafts because of the error when submitting a new review on front
        $posts = $model->items(['status' => [
            ToolReview::POST_STATUS_PUBLISH,
            ToolReview::POST_STATUS_PRIVATE
        ]]);

        foreach ($posts as $post) {
            $model->sync($post);
        }

        echo 'Done!';
        exit;
    }
}
