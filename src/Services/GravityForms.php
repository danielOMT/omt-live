<?php

namespace OMT\Services;

class GravityForms
{
    public static function isPluginScript(string $src)
    {
        return
            strpos($src, 'jquery.json.min.js') !== false ||
            strpos($src, 'gravityforms.min.js') !== false ||
            strpos($src, 'conditional_logic.min.js') !== false ||
            strpos($src, 'placeholders.jquery.min.js') !== false;
    }
}
