<?php

namespace OMT\Module;

use OMT\Model\Datahost\Webinar;
use OMT\View\WebinarView;

class WebinarsTeaser extends Module
{
    protected $image;
    protected $topHeadline;
    protected $headline;
    protected $introText;

    public function __construct(array $data)
    {
        $this->image = $data['teaser_bild'];
        $this->topHeadline = $data['top_headline'];
        $this->headline = $data['headline'];
        $this->introText = $data['introtext_optional'];
    }

    /**
     * Display upcoming webinars as list (<ul>)
     */
    public function render()
    {
        $webinars = Webinar::init()->activeItems(
            ['timeframe' => Webinar::UPCOMING_WEBINARS],
            [
                'limit' => 3,
                'order' => 'date'
            ]
        );

        return WebinarView::loadTemplate('webinars-teaser-module', [
            'webinars' => $webinars,
            'image' => $this->image,
            'topHeadline' => $this->topHeadline,
            'headline' => $this->headline,
            'introText' => $this->introText
        ]);
    }
}
