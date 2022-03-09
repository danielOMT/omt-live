<?php

namespace OMT\Model;

use WC_Product;
use WC_Product_Simple;
use WC_Product_Variation;

class WooCart extends Model
{
    public function add(WC_Product $product, $quantity = 1)
    {
        $productId = $product instanceof WC_Product_Variation
            ? $product->parent_id
            : $product->get_id();

        $variationId = $product instanceof WC_Product_Variation
            ? $product->get_id()
            : 0;

        WC()->cart->add_to_cart($productId, $quantity, $variationId);
    }

    public function clear()
    {
        WC()->cart->empty_cart();
    }

    public function productCheckoutUrl(WC_Product_Simple $product)
    {
        return "/kasse/?add-to-cart=" . $product->get_id();
    }

    public function productVariationCheckoutUrl(WC_Product_Variation $product)
    {
        return "/kasse/?add-to-cart=" . $product->parent_id . "&variation_id=" . $product->get_id();
    }

    public function existsOmtMagazinProductsInCart()
    {
        $model = WooProduct::init();

        foreach (WC()->cart->get_cart_contents() as $product) {
            if (isset($product['data']) && $product['data'] instanceof WC_Product && $model->isOmtMagazinProduct($product['data'])) {
                return true;
            }
        }

        return false;
    }
}
