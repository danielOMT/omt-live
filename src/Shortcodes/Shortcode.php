<?php

namespace OMT\Shortcodes;

abstract class Shortcode
{
    abstract protected function shortcode();

    abstract public function handle();

    public function init()
    {
        add_shortcode($this->shortcode(), [$this, 'handle']);
    }
}
