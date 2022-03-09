<?php

namespace OMT\Module;

use OMT\Enum\AvatarUrl;
use OMT\View\View;

class Reviews extends Module
{
    public $items;

    public $fixed_top_right;

    public function render()
    {
        return View::loadTemplate(['modules' => 'reviews'], [
            'items' => $this->items,
            'fixedTopRight' => $this->fixed_top_right,
            'avatarUrls' => AvatarUrl::all()
        ]);
    }
}
