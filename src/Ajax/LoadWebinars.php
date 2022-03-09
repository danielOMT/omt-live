<?php

namespace OMT\Ajax;

use OMT\Model\Datahost\Webinar;
use OMT\Services\Response;
use OMT\View\WebinarView;

class LoadWebinars extends Ajax
{
    /**
     * Get all past webinars by offset
     */
    public function handle()
    {
        Response::json([
            'content' => WebinarView::loadTemplate('ajax-items', [
                'offset' => (int) $_POST['offset'],
                'webinars' => Webinar::init()->activeItems(
                    [
                        'timeframe' => Webinar::PAST_WEBINARS,
                        'category' => array_filter(explode(',', $_POST['categories']))
                    ],
                    [
                        'order' => 'date',
                        'order_dir' => 'DESC',
                        'offset' => (int) $_POST['offset'],
                        'with' => 'experts'
                    ]
                )
            ])
        ]);
    }

    public function enqueueScripts()
    {
        wp_enqueue_script('ajax-load-webinars', get_template_directory_uri() . '/library/js/custom/load-webinars.js', ['jquery'], null, true);
        wp_localize_script('ajax-load-webinars', $this->getAction(), [
            'nonce' => wp_create_nonce($this->getAction()),
            'ajax_url' => admin_url('admin-ajax.php')
        ]);
    }

    protected function getAction()
    {
        return 'omt_load_webinars';
    }
}
