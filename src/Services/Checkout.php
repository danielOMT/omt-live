<?php

namespace OMT\Services;

use OMT\Model\WooProduct;
use WC_Product;

class Checkout
{
    public static function displayParticipantFields()
    {
        $model = WooProduct::init();

        foreach (WC()->cart->get_cart_contents() as $product) {
            // Don't display participant fields if it's "konferenzticket" product
            // TODO: Old programmer code, Not sure if this is needed anymore, check if exists product with id "201855"
            if ($product['data']->id == 201855) {
                return false;
            }

            // Don't display participant fields if it's "OMT Magazin" or "eBook" product
            if ($product['data'] instanceof WC_Product && ($model->isOmtMagazinProduct($product['data']) || $model->isEbookProduct($product['data']))) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if "Rechnung" payment method has to be disabled
     * Allowed for administrators
     * Disabled for regular users and products "OMT Magazin Printausgabe" / "eBook"
     */
    public static function disableInvoicePaymentMethod()
    {
        if (!Roles::isAdministrator()) {
            $model = WooProduct::init();

            foreach (WC()->cart->get_cart_contents() as $product) {
                if ($product['data'] instanceof WC_Product && ($model->isOmtMagazinPrintEditionProduct($product['data']) || $model->isEbookProduct($product['data']))) {
                    return true;
                }
            }
        }

        return false;
    }
}
