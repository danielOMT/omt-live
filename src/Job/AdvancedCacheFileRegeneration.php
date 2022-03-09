<?php

namespace OMT\Job;

/**
 * Add initialization of core OMT scripts to advanced-cache.php file, when WP Rocket regenerates it
 */
class AdvancedCacheFileRegeneration extends Job
{
    public function __construct()
    {
        add_filter('rocket_advanced_cache_file', [$this, 'addContent']);
    }

    public function addContent($content)
    {
        if (!empty($content)) {
            $content .= "\r\n";
            $content .= "// Init custom scripts, functions... BEFORE load WP, allows to register hooks earlier\r\n";
            $content .= "require_once WP_CONTENT_DIR . '/themes/omt/core/initialization.php';";
        }

        return $content;
    }
}
