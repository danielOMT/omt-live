<?php

namespace OMT\Job;

/**
 * Hide feed link on the single post when comments are enabled
 */
class HideExtraFeedLink extends Job
{
    public function __construct()
    {
        add_action('wp_head', [$this, 'handle'], 2);
    }

    public function handle()
    {
        if (is_singular()) {
            $id = 0;
            $post = get_post($id);

            if (comments_open() || pings_open() || $post->comment_count > 0) {
                remove_action('wp_head', 'feed_links_extra', 3);
            }
        }
    }
}
