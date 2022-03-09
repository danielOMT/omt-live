<?php

// Change Shop URL for account subscriptions page
add_filter('woocommerce_return_to_shop_redirect', function ($url) {
    if (strpos($_SERVER['REQUEST_URI'], '/mein-konto/subscriptions') !== false) {
        return '/downloads/magazin';
    }

    return $url;
});
