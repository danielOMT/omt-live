<?php

namespace OMT\Services;

use OMT\Model\WooProduct;
use WC_Order;
use WC_Product;

class Order
{
    public static function hasDownloadableProducts(WC_Order $order)
    {
        return $order->has_downloadable_item();
    }

    public static function hasOmtMagazinProducts(WC_Order $order)
    {
        $model = WooProduct::init();

        foreach ($order->get_items() as $item) {
            /** @var \WC_Order_Item_Product $item */
            $product = $item->get_product();

            if ($product && $product instanceof WC_Product && $model->isOmtMagazinProduct($product)) {
                return true;
            }
        }

        return false;
    }
}
