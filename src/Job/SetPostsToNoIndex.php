<?php

namespace OMT\Job;

class SetPostsToNoIndex extends Job
{
    protected $noIndexPosts = [
        'christmas',
        'omt_downloads',
        'omt_magazin',
        'omt_student',
        'omt_ebook',
    ];

    public function __construct()
    {
        add_filter('wp_robots', [$this, 'noIndex']);
    }

    public function noIndex(array $robots)
    {
        if (in_array(getPost()->post_type, $this->noIndexPosts)) {
            $robots['noindex'] = true;
        }

        return $robots;
    }
}
