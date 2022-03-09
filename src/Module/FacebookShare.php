<?php

namespace OMT\Module;

use OMT\View\View;

class FacebookShare extends Module
{
    public $url;

    public $description;

    public $sharing_title;

    public function render()
    {
        return View::loadTemplate(['modules' => 'facebook-share'], [
            'url' => $this->url,
            'description' => $this->description,
            'sharingTitle' => $this->sharing_title
        ]);
    }
}
