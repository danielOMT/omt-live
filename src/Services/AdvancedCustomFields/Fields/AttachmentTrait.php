<?php

namespace OMT\Services\AdvancedCustomFields\Fields;

trait AttachmentTrait
{
    protected function getAttachmentUrl(string $file)
    {
        $uploads = wp_get_upload_dir();

        // Follow wp_get_attachment_url() function in /wp-includes/post.php
        if ($uploads && $uploads['error'] === false) {
            // Check that the upload base exists in the file location.
            if (0 === strpos($file, $uploads['basedir'])) {
                // Replace file location with url location.
                $url = str_replace($uploads['basedir'], $uploads['baseurl'], $file);
            } elseif (false !== strpos($file, 'wp-content/uploads')) {
                // Get the directory name relative to the basedir (back compat for pre-2.7 uploads).
                $url = trailingslashit($uploads['baseurl'] . '/' . _wp_get_attachment_relative_path($file)) . wp_basename($file);
            } else {
                // It's a newly-uploaded file, therefore $file is relative to the basedir.
                $url = $uploads['baseurl'] . "/" . $file;
            }
        }

        // On SSL front end, URLs should be HTTPS.
        if (is_ssl() && !is_admin()) {
            $url = set_url_scheme($url);
        }

        // TODO: Check why this filter makes additional query to DB
        // $url = apply_filters('wp_get_attachment_url', $url, $value['attachment_id']);

        if (!$url) {
            return false;
        }

        return $url;
    }
}
