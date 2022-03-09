<?php

namespace OMT\Shortcodes;

use OMT\View\OrderView;

class ThankYouPageOrderDetails extends Shortcode
{
    public function handle()
    {
        // Check if the order ID exists and if is set the order key
        if (!isset($_GET['order']) || !isset($_GET['key']) || !isset($_GET['omt-dwtyp'])) {
            return;
        }

        $order = wc_get_order((int) $_GET['order']);

        // Check if order keys are the same
        if ($_GET['key'] != $order->get_order_key()) {
            return;
        }

        return OrderView::loadTemplate('thank-you-page-details', ['order' => $order]);
    }

    protected function shortcode()
    {
        return 'thank_you_page_order_details';
    }
}
