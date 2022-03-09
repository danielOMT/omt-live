<?php

use OMT\Model\WooCart;
use OMT\Model\WooProduct;

function vb_add_magazin_product_to_cart()
{
    $response = [
        'status' => 500,
        'message' => 'Something is wrong, please try again later ...',
        'content' => false
    ];

    try {
        $productId = (int) $_POST['product_id'];
        $cartModel = WooCart::init();

        $product = $_POST['type'] == 'variation'
            ? WooProduct::init()->getVariation($productId)
            : WooProduct::init()->getProduct($productId);

        $cartModel->clear();
        $cartModel->add($product);

        $response['status'] = 200;
    } catch (Exception $ex) {
        $response['message'] = $ex->getMessage();
    }

    die(json_encode($response));
}

add_action('wp_ajax_add_magazin_product_to_cart', 'vb_add_magazin_product_to_cart');
add_action('wp_ajax_nopriv_add_magazin_product_to_cart', 'vb_add_magazin_product_to_cart');
