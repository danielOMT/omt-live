<?php

namespace OMT\Services;

use OMT\Job\Sync\ArticlesSync;
use OMT\Job\Sync\ExpertsSync;
use OMT\Job\Sync\ToolReviewsSync;
use OMT\Job\Sync\ToolsSync;
use OMT\Job\Sync\WebinarsSync;

class PostsSynchronization
{
    public static function init()
    {
        // Don't run database synchronization if is enabled JSON Sync
        if (!defined('USE_JSON_POSTS_SYNC') || USE_JSON_POSTS_SYNC === false) {
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }

            WebinarsSync::init();
            ToolsSync::init();
            ToolReviewsSync::init();
            ArticlesSync::init();
            ExpertsSync::init();
        }
    }
}
