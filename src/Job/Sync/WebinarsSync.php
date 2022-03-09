<?php

namespace OMT\Job\Sync;

use OMT\Job\Job;
use OMT\Model\Datahost\Webinar as DatahostWebinar;
use OMT\Model\Webinar;
use OMT\Services\Roles;
use WP_Post;

class WebinarsSync extends Job
{
    public function __construct()
    {
        // Sync webinar when the corresponding post has been saved
        // Initialize hook later (priority = 15) to have all the actual data from other plugins like ACF
        add_action('save_post', [$this, 'save'], 15, 3);

        // Sync deletion (destroy) when the corresponding post has been deleted
        add_action('deleted_post', [$this, 'destroy'], 15, 2);

        // Sync all webinars manually running /wp-admin/admin-ajax.php?action=sync_all_webinars
        add_action('wp_ajax_sync_all_webinars', [$this, 'saveAll']);
    }

    public function save($postId, WP_Post $post, bool $update)
    {
        if (defined('DOING_AJAX') && DOING_AJAX) {
            return;
        }

        if ($post->post_type !== Webinar::init()->getPostTypeName()) {
            return;
        }

        if (wp_is_post_revision($post)) {
            return;
        }

        if (isset($post->post_status) && $post->post_status == 'auto-draft') {
            return;
        }

        // Skip sync if the webinar is treated as a Page
        if (get_field('als_seite_behandeln', $post->ID) == 1) {
            return;
        }

        Webinar::init()->sync($post);
    }

    public function destroy($postid, WP_Post $post)
    {
        if (defined('DOING_AJAX') && DOING_AJAX) {
            return;
        }

        if ($post->post_type !== Webinar::init()->getPostTypeName()) {
            return;
        }

        DatahostWebinar::init()->destroy($post->ID);
    }

    public function saveAll()
    {
        if (!Roles::isAdministrator()) {
            return false;
        }

        $model = Webinar::init();
        $posts = $model->items(['status' => [
            Webinar::POST_STATUS_PUBLISH,
            Webinar::POST_STATUS_DRAFT,
            Webinar::POST_STATUS_PRIVATE
        ]]);

        foreach ($posts as $post) {
            // Skip sync if the webinar is treated as a Page
            if (get_field('als_seite_behandeln', $post->ID) != 1) {
                $model->sync($post);
            }
        }

        echo "Done!";
        exit;
    }
}
