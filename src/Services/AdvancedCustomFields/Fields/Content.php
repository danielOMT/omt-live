<?php

namespace OMT\Services\AdvancedCustomFields\Fields;

/**
 * @todo Build own Wysiwyg formater instead of acf_the_content (files class-acf-field-wysiwyg.php) if ACF will be disabled
 */
class Content extends Field
{
    public function getValue(int $postId = null, string $key, $rawValue)
    {
        return $rawValue;
    }

    public function format($value)
    {
        // Follow the_content function in /wp-includes/post-template.php, the same do ACF Wysiwyg formater
        return str_replace(']]>', ']]&gt;', apply_filters('acf_the_content', $value));
    }
}
