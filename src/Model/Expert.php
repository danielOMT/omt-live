<?php

namespace OMT\Model;

use OMT\Model\Datahost\Expert as DatahostExpert;
use WP_Post;

class Expert extends PostModel
{
    protected $postType = 'speaker';

    public function sync(WP_Post $post)
    {
        return DatahostExpert::init()->store([
            'id' => $post->ID,
            'name' => get_the_title($post),
            'url' => get_the_permalink($post)
        ]);
    }
}
