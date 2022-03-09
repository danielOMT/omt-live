<?php

namespace OMT\Module;

use OMT\View\View;

class Characteristics extends Module
{
    public $headline;

    public $text;

    public $button_label;

    public $button_link;

    public $text_below;

    public $image;

    public function render()
    {
        return View::loadTemplate(['modules' => 'characteristics'], [
            'headline' => $this->headline,
            'text' => $this->text,
            'button_label' => $this->button_label,
            'button_link' => $this->button_link,
            'text_below' => $this->text_below,
            'image' => $this->image
        ]);
    }
}
