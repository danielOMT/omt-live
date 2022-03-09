<?php

use OMT\Model\WooCart;
use OMT\Model\WooProduct;

$product = WooProduct::init()->getProduct($zeile['inhaltstyp'][0]['product']);
?>

<div class="full-width-promo-content">
    <h4><?php echo $zeile['inhaltstyp'][0]['headline'] ?></h4>

    <?php if (is_array($zeile['inhaltstyp'][0]['items']) && count($zeile['inhaltstyp'][0]['items'])) : ?>
        <div class="full-width-promo-items">
            <?php foreach ($zeile['inhaltstyp'][0]['items'] as $item) : ?>
                <div class="full-width-promo-item">
                    <div class="full-width-promo-item-icon">
                        <img src="<?php echo $zeile['inhaltstyp'][0]['items_icon']['url']; ?>" alt="Icon" />
                    </div>
                    <div class="full-width-promo-item-content">
                        <?php echo $item['item']; ?>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif ?>

    <?php if (!empty($zeile['inhaltstyp'][0]['headline_2'])) : ?>
        <div class="full-width-promo-headline-2">
            <?php echo $zeile['inhaltstyp'][0]['headline_2'] ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($zeile['inhaltstyp'][0]['content'])) : ?>
        <div class="full-width-promo-headline-content">
            <?php echo nl2br($zeile['inhaltstyp'][0]['content']) ?>
        </div>
    <?php endif; ?>

    <?php if ($product) : ?>
        <a href="<?php echo WooCart::init()->productCheckoutUrl($product) ?>" class="button button-red full-width-promo-product-btn">
            <?php echo $zeile['inhaltstyp'][0]['button'] ?>
        </a>
    <?php endif; ?>
</div>
<div class="full-width-promo-image-container">
    <?php if (!empty($zeile['inhaltstyp'][0]['image_text'])) : ?>
        <div class="full-width-promo-image-text">
            <?php echo $zeile['inhaltstyp'][0]['image_text'] ?>
        </div>
    <?php endif; ?>

    <div class="full-width-promo-image">
        <img src="<?php echo $zeile['inhaltstyp'][0]['image']['sizes']['medium_large']; ?>" alt="<?php echo $zeile['inhaltstyp'][0]['headline'] ?>" />
    </div>
</div>