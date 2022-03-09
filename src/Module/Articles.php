<?php

namespace OMT\Module;

use OMT\Ajax\LoadArticles;
use OMT\Model\Datahost\Article;
use OMT\Model\PostModel;
use OMT\View\View;

class Articles extends Module
{
    protected $limit;
    protected $loadMoreButton = false;
    protected $postTypes;
    protected $format;
    protected $author;
    protected $offset;
    protected $buttonLabel;
    protected $buttonUrl;
    protected $featured;
    protected $newTab;
    protected $highlightFirst = false;

    public function __construct(array $data)
    {
        $this->limit = (int) $data['anzahl_angezeigter_artikel'];
        $this->loadMoreButton = $data['mehr_laden_button_anzeigen'] == 1 ? true : false;
        $this->format = $data['format'] ?: 'teaser-small';
        $this->author = $data['autor'] ? (int) $data['autor'] : null;
        $this->offset = $data['ab_x'] > 0 ? ($data['ab_x'] - 1) : 0;
        $this->buttonLabel = $data['button_text'] ?? null;
        $this->buttonUrl = $data['button_link'] ?? null;
        $this->featured = isset($data['non_featured']) && !$data['non_featured'] ? true : false;
        $this->newTab = $data['new_tab'] == 1 ? true : false;
        $this->highlightFirst = in_array($this->format, ['teaser-small', 'mixed']) && $this->featured ? true : false;
        $this->postTypes = in_array('alle', (array) $data['kategorie'])
            ? null
            : array_filter((array) $data['kategorie']);
    }

    public function render()
    {
        $model = Article::init();
        $loadMoreArticles = false;
        $filters = [
            'status' => PostModel::POST_STATUS_PUBLISH,
            'recap' => false,
            'expert' => $this->author
        ];

        $options = [
            'order' => 'post_date',
            'order_dir' => 'DESC',
            'offset' => $this->offset,
            'limit' => $this->limit,
            'with' => ['experts']
        ];

        if ($this->postTypes) {
            $filters['postType'] = $this->postTypes;
        }

        if ($this->loadMoreButton && $model->itemsCount($filters, $options) > $this->limit) {
            $loadMoreArticles = true;
            LoadArticles::getInstance()->enqueueScripts();
        }

        return View::loadTemplate(['modules' => 'articles'], [
            'articles' => Article::init()->items($filters, $options),
            'highlightFirst' => $this->highlightFirst,
            'format' => $this->format,
            'newTab' => $this->newTab,
            'buttonLabel' => $this->buttonLabel,
            'buttonUrl' => $this->buttonUrl,
            'loadMoreArticles' => $loadMoreArticles,
            'loadMoreOffset' => $this->offset + $this->limit,
            'postTypes' => $this->postTypes
        ]);
    }
}
