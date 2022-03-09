<?php

namespace OMT\Job;

class SetLangAttributeToGerman extends Job
{
    public function __construct()
    {
        add_filter('language_attributes', [$this, 'handle'], 9, 2);
    }

    public function handle($output, $doctype)
    {
        return str_replace(['en-US', 'de-DE'], 'Deutsch', $output);
    }
}
