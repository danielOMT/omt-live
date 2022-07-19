<?php

namespace OMT\Job\WooCommerce;

use OMT\Job\Job;
use WC_Order;

/**
 * Use custom thank you page for WooCommerce products after purchase
 */
class CustomThankYouPage extends Job
{
    /**
     * Register redirect action before displaying the original "Thank you" page
     * Redirect only if we're not already on the custom thank you page
     * Redirect before hitting the original page because original actions will be called after, in custom shortcode
     *
     * Using of "thank_you_page_order_details" shortcode on Pages is mandatory if original WooCommerce hooks have to be called
     * Hooks like (woocommerce_before_thankyou/woocommerce_thankyou_{payment_method}/woocommerce_thankyou/woocommerce_thankyou_order_received_text)
     */
    public function __construct()
    {
        if (isset($_GET['omt-dwtyp'])) {
            wc_maybe_define_constant('WOOCOMMERCE_CHECKOUT', true);
        } else {
            add_action('woocommerce_before_thankyou', [$this, 'redirect'], -1);
        }
    }

    public function redirect($orderId)
    {
        $order = wc_get_order($orderId);

        if (!$order->has_status('failed')) {
            $page = $this->getCustomThankYouPage($order);

            if ($page) {
                wp_safe_redirect(
                    $page . '?order=' . absint($order->get_id()) . '&key=' . wc_clean($_GET['key']) . '&omt-dwtyp=1'
                );

                exit;
            }
        }
    }

    //Gets all the product ids and assigned thank you pages from custom module
    protected function getCustomThankYouPage(WC_Order $order)
    {   
        global $woocomerce;
        foreach ($order->get_items() as $item) {
            $product = $item->get_product();
            $id = $product->get_id();
        }
        //Gettin product variations if exists
        if($variation = wc_get_product($id)){
            $parentId = wc_get_product( $variation->get_parent_id() );
            $parentId->id;
            //First it checks if product has variationos
            foreach ((array) get_field('products_thank_you_pages', 'options') as $value) {
                if($parentId->id == $value['product']){
                    return $value['page'];
                }
            }
        }else{
            foreach ((array) get_field('products_thank_you_pages', 'options') as $value) {
                if ($this->orderContainsProduct($order, (int) $value['product'])) {
                    return $value['page'];
                }
            }
        }

        
        

        foreach ((array) get_field('categories_thank_you_pages', 'options') as $value) {
            if ($this->orderContainsCategory($order, (int) $value['category'])) {
                return $value['page'];
            }
        }

        return false;
    }

    protected function orderContainsProduct(WC_Order $order, int $productId)
    {   
        foreach ($order->get_items() as $item) {
            $product = $item->get_product();

            if ($product && $product->get_id() == $productId) {
                return true;
            }
        }

        return false;
    }

    protected function orderContainsCategory(WC_Order $order, int $categoryId)
    {
        foreach ($order->get_items() as $item) {
            $product = $item->get_product();

            if ($product && in_array($categoryId, $product->get_category_ids())) {
                return true;
            }
        }

        return false;
    }
}
