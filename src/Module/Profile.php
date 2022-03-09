<?php

namespace OMT\Module;

use OMT\View\ProfileView;

class Profile extends Module
{
    public $image;

    public $title;

    public $text;

    public $url;

    public function render()
    {
        return ProfileView::loadTemplate('default', [
            'title' => $this->title,
            'image' => $this->image,
            'text' => $this->text,
            'url' => $this->url
        ]);
    }
}
