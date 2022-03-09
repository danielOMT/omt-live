<?php

namespace OMT\Module;

use OMT\View\TeamView;

class TeamMember extends Module
{
    public $content;

    public $default_image;

    public $mouseover_image;

    public $position;

    public $social_icons;

    public $zertifikate;

    public function render()
    {
        return TeamView::loadTemplate('mouseover-image-item', [
            'content' => $this->content,
            'default_image' => $this->default_image,
            'mouseover_image' => $this->mouseover_image,
            'position' => $this->position,
            'social_icons' => (array) $this->social_icons,
            'certificates' => (array) $this->zertifikate
        ]);
    }
}
