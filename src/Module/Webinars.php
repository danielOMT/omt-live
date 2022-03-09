<?php

namespace OMT\Module;

use OMT\Ajax\LoadWebinars;
use OMT\Model\Datahost\Webinar;
use OMT\Model\PostModel;
use OMT\Services\WebinarsFilter;
use OMT\Services\ArraySort;
use OMT\View\WebinarView;

class Webinars extends Module
{
    protected $expert;
    protected $limit;
    protected $loadMoreButton = false;
    protected $timeframe;
    protected $highlightFirst;
    protected $categories;
    protected $buttonText;
    protected $buttonUrl;

    public function __construct(array $data)
    {
        $this->expert = $data['autor'];
        $this->limit = $data['anzahl_angezeigter_webinare'];
        $this->categories = array_filter((array) $data['kategorie']);
        $this->buttonText = $data['button_text'];
        $this->buttonUrl = $data['button_link'];
        $this->timeframe = Webinar::ALL_WEBINARS;

        if ($data['webinar_status'] == 'zukunft') {
            $this->timeframe = Webinar::UPCOMING_WEBINARS;
        } elseif ($data['webinar_status'] == 'vergangenheit') {
            $this->timeframe = Webinar::PAST_WEBINARS;
        }

        $this->highlightFirst = $data['highlight_next'] && $this->timeframe == Webinar::UPCOMING_WEBINARS;

        // Display "Load more" button if,
        // - is selected to display all webinars and checkbox is selected, or
        // - is selected to display past webinars and no is selected filtering by categories (functionality taken from old .json solution)
        if (
            ($this->timeframe == Webinar::ALL_WEBINARS && $data['mehr_laden_button_anzeigen'] == 1) ||
            ($this->timeframe == Webinar::PAST_WEBINARS && !count($this->categories))
        ) {
            $this->loadMoreButton = true;
        }
    }

    public function render()
    {
        $model = Webinar::init();
        $loadMoreWebinars = false;

        $filters = [
            'status' => PostModel::POST_STATUS_PUBLISH,
            'hidden' => false,
            'timeframe' => $this->timeframe,
            'expert' => $this->expert,
            'category' => $this->categories
        ];

        $options = [
            'limit' => $this->limit,
            'order' => 'date',
            'order_dir' => in_array($this->timeframe, [Webinar::PAST_WEBINARS, Webinar::ALL_WEBINARS]) ? 'DESC' : 'ASC',
            'with' => 'experts'
        ];

        if ($this->loadMoreButton && $model->itemsCount($filters, $options) > $this->limit) {
            $loadMoreWebinars = true;
            LoadWebinars::getInstance()->enqueueScripts();
        }

        $webinars = $model->items($filters, $options);

        // Make a new webinars array, first upcoming webinars sorted by date ASC then past webinars sorted by date DESC
        if ($this->timeframe === Webinar::ALL_WEBINARS) {
            $webinars = [
                ...ArraySort::byDateAsc(WebinarsFilter::upcoming($webinars)),
                ...ArraySort::byDateDesc(WebinarsFilter::past($webinars))
            ];
        }

        return WebinarView::loadTemplate('webinars-module', [
            'webinars' => $webinars,
            'categories' => $this->categories,
            'limit' => $this->limit,
            'highlightFirst' => $this->highlightFirst,
            'buttonText' => $this->buttonText,
            'buttonUrl' => $this->buttonUrl,
            'loadMoreWebinars' => $loadMoreWebinars
        ]);
    }
}
