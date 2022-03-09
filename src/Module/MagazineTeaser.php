<?php

namespace OMT\Module;

use OMT\Model\Datahost\Article;
use OMT\View\View;

class MagazineTeaser extends Module
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

    public function render()
    {
        $options = [
            'order' => 'post_date',
            'order_dir' => 'DESC',
            'limit' => 3,
            'with' => ['experts']
        ];

        return View::loadTemplate(['modules' => 'magazine-teaser'], [
            'articles' => Article::init()->activeItems([], $options),
            'image' => $this->image,
            'topHeadline' => $this->topHeadline,
            'headline' => $this->headline,
            'introText' => $this->introText
        ]);
    }
}
