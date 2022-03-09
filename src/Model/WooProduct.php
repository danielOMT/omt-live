<?php

namespace OMT\Model;

use WC_Product;
use WC_Product_Simple;
use WC_Product_Variation;

class WooProduct extends Model
{
    public function getProduct($id)
    {
        if (is_numeric($id) && $id) {
            return new WC_Product_Simple($id);
        }

        return null;
    }

    public function getVariation($variationId)
    {
        if (is_numeric($variationId) && $variationId) {
            return new WC_Product_Variation($variationId);
        }

        return null;
    }

    public function isOmtMagazinProduct(WC_Product $product)
    {
        return strpos($this->getProductSlug($product), 'omt-magazin') === 0;
    }

    public function isOmtMagazinPrintEditionProduct(WC_Product $product)
    {
        return $this->getProductSlug($product) == 'omt-magazin-printausgabe';
    }

    public function isEbookProduct(WC_Product $product)
    {
        return strpos($this->getProductSlug($product), 'omt-ebook') === 0;
    }

    /**
     * Get slug of the product
     *
     * - For variations get slug of the parent product
     * - There is a bug, when update permalink in backend slug of the variation product (post_name in DB) does not update
     */
    protected function getProductSlug(WC_Product $product)
    {
        if ($product instanceof WC_Product_Variation) {
            $parentProduct = $this->getProduct($product->get_parent_id());

            if ($parentProduct) {
                return $parentProduct->get_slug();
            }
        }

        return $product->get_slug();
    }
}
