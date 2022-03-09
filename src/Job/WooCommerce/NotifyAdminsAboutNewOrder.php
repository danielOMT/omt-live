<?php

namespace OMT\Job\WooCommerce;

use OMT\Job\Job;
use OMT\Services\Order;
use WC_Order;

/**
 * Add additional recipients to receive admin emails about new orders when OmtMagazin product has been bought
 */
class NotifyAdminsAboutNewOrder extends Job
{
    protected $emails = [
        'isabelle.reuter@reachx.de'
    ];

    public function __construct()
    {
        add_action('woocommerce_email_recipient_new_order', [$this, 'recipients'], 10, 2);
    }

    public function recipients($emails, WC_Order $order)
    {
        if (Order::hasOmtMagazinProducts($order)) {
            $recipients = array_map('trim', (array) explode(',', $emails));
            $recipients = [...$recipients, ...$this->emails];

            $emails = implode(', ', $recipients);
        }

        return $emails;
    }
}
