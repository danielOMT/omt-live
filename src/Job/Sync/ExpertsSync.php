<?php

namespace OMT\Job\Sync;

use OMT\Job\Job;
use OMT\Model\Datahost\Expert as DatahostExpert;
use OMT\Model\Expert;
use WP_Post;

class ExpertsSync extends Job
{
    public function __construct()
    {
        // Sync expert when the corresponding post has been saved
        // Initialize hook later (priority = 15) to have all the actual data from other plugins like ACF
        add_action('save_post', [$this, 'save'], 15, 3);

        // Sync deletion (destroy) when the corresponding post has been deleted
        add_action('deleted_post', [$this, 'destroy'], 15, 2);
    }

    public function save($postId, WP_Post $post, bool $update)
    {
        if (defined('DOING_AJAX') && DOING_AJAX) {
            return;
        }

        if ($post->post_type !== Expert::init()->getPostTypeName()) {
            return;
        }

        if (wp_is_post_revision($post)) {
            return;
        }

        if (isset($post->post_status) && $post->post_status == 'auto-draft') {
            return;
        }

        Expert::init()->sync($post);
    }

    public function destroy($postid, WP_Post $post)
    {
        if (defined('DOING_AJAX') && DOING_AJAX) {
            return;
        }

        if ($post->post_type !== Expert::init()->getPostTypeName()) {
            return;
        }

        DatahostExpert::init()->destroy($post->ID);
    }
}
