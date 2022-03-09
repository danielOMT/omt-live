<?php

namespace OMT\StructuredData;

use OMT\Services\Date;
use OMT\View\WebinarView;

class WebinarVideo extends StructuredData
{
    public function render()
    {
        return WebinarView::loadMarkup('video', [
            'name' => $this->entity->preview_title,
            'description' => strip_tags($this->entity->description),
            'thumbnailUrl' => $this->entity->image_550,
            'uploadDate' => Date::get($this->entity->post_date)->format('c'),
            'duration' => $this->generateDuration()
        ]);
    }

    protected function generateDuration()
    {
        if ($this->entity->video_duration != '00:00:00') {
            $parts = explode(':', $this->entity->video_duration);

            return 'PT' . $parts[0] . 'H' . $parts[1] . 'M' . $parts[2] . 'S';
        }

        return null;
    }
}
