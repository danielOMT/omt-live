<?php

use OMT\Model\WooCart;

/**
 * Make field "Telefonnummer" optional for "Omt Magazin" products
 */
add_filter('woocommerce_checkout_fields', function (array $fields) {
    if (array_key_exists('billing', $fields) && array_key_exists('billing_phone', $fields['billing']) && WooCart::init()->existsOmtMagazinProductsInCart()) {
        $fields['billing']['billing_phone']['required'] = false;
    }

    return $fields;
}, 99999);
