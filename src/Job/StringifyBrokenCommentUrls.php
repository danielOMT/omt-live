<?php

namespace OMT\Job;

/**
 * Don't make clickable comment URLs that aren't validated by filter_var()
 */
class StringifyBrokenCommentUrls extends Job
{
    public function __construct()
    {
        add_filter('clean_url', [$this, 'handle'], 10, 3);
    }

    public function handle($url, $original_url, $context)
    {
        if ($context === 'display' && doing_filter('comment_text') && filter_var($url, FILTER_VALIDATE_URL) === false) {
            $url = '';
        }

        return $url;
    }
}
