<?php

use OMT\Model\WooCart;
use OMT\Model\WooProduct;
use OMT\Services\Date;
use OMT\View\DownloadView;

$model = WooProduct::init();
$post_id = get_the_ID();
$deactivateDownloadingUntil = getPost()->field('deactivate_downloading_until', 'date_object');

$magazineProduct = $model->getProduct(
    get_field('magazine_abo_product', 'options')
);

$productVariation = $model->getVariation(
    get_field("magazinbestellung_produktvariante_id")
);

if ($magazineProduct || $productVariation) {
    wc_maybe_define_constant('WOOCOMMERCE_CHECKOUT', true);

    // It has to be something inside the cart in order to render checkout shortcode
    // Add "Printausgabe" product first to cart (if exist), to display correct checkout if Online Tab will be hidden
    WooCart::init()->add($productVariation ?: $magazineProduct);
}
?>
<?php get_header(); ?>

<?php if (getPost()->field('downloads_use_new_template', 'bool')) : ?>
    <?php
    if ($productVariation) {
        echo DownloadView::loadTemplate('single', [
            'title' => get_the_title(),
            'leftImageUrl' => getPost()->field('left_image', 'image_array'),
            'content' => getPost()->field('inhaltseditor', 'content'),
            'peopleHeadline' => getPost()->field('downloads_people_headline', 'text'),
            'people' => getPost()->field('downloads_people', 'repeater'),
            'reviews' => getPost()->field('downloads_reviews', 'repeater'),
            'firstContent' => getPost()->field('downloads_content_1', 'content'),
            'firstContentImage' => getPost()->field('downloads_content_image_1', 'image_array'),
            'secondContent' => getPost()->field('downloads_content_2', 'content'),
            'secondContentImage' => getPost()->field('downloads_content_image_2', 'image_array'),
            'buttonsAsRows' => getPost()->field('downloads_buttons_as_rows', 'bool'),
            'downloadButton' => (object) [
                'label' => getPost()->field('downloads_download_button_label', 'text'),
                'formId' => getPost()->field('right_hubspot'),
                'deactivateUntil' => $deactivateDownloadingUntil
            ],
            'firstCheckoutButton' => (object) [
                'label' => getPost()->field('downloads_buy_button_label', 'text'),
                'product' => $productVariation,
                'onClick' => "addMagazinProductToCart(" . (int) $productVariation->get_id() . ", 'variation')"
            ],
            'secondCheckoutButton' => (object) [
                'label' => getPost()->field('downloads_buy_button_2_label', 'text'),
                'product' => $magazineProduct,
                'onClick' => "addMagazinProductToCart(" . (int) $magazineProduct->get_id() . ")"
            ]
        ]); } else {
        echo DownloadView::loadTemplate('single', [
            'title' => get_the_title(),
            'leftImageUrl' => getPost()->field('left_image', 'image_array'),
            'content' => getPost()->field('inhaltseditor', 'content'),
            'peopleHeadline' => getPost()->field('downloads_people_headline', 'text'),
            'people' => getPost()->field('downloads_people', 'repeater'),
            'reviews' => getPost()->field('downloads_reviews', 'repeater'),
            'firstContent' => getPost()->field('downloads_content_1', 'content'),
            'firstContentImage' => getPost()->field('downloads_content_image_1', 'image_array'),
            'secondContent' => getPost()->field('downloads_content_2', 'content'),
            'secondContentImage' => getPost()->field('downloads_content_image_2', 'image_array'),
            'buttonsAsRows' => getPost()->field('downloads_buttons_as_rows', 'bool'),
            'downloadButton' => (object) [
                'label' => getPost()->field('downloads_download_button_label', 'text'),
                'formId' => getPost()->field('right_hubspot'),
                'deactivateUntil' => $deactivateDownloadingUntil
            ],
            'secondCheckoutButton' => (object) [
                'label' => getPost()->field('downloads_buy_button_2_label', 'text'),
                'product' => $magazineProduct,
                'onClick' => "addMagazinProductToCart(" . (int) $magazineProduct->get_id() . ")"
            ]
        ]);
    } ?>
<?php else : ?>
    <div id="content" xmlns:background="http://www.w3.org/1999/xhtml">
        <div id="inner-content" class="wrap clearfix no-hero">
            <div id="main" class="omt-row blog-single  clearfix" role="main">
                <h1 class="entry-title single-title h2 has-margin-bottom-30" itemprop="headline"><?php the_title(); ?></h1>

                <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
                    <section class="entry-content clearfix" itemprop="articleBody">
                        <div class="content-intro clearfix">
                            <div class="half left-half">
                                <img class="download-image" alt="<?php echo get_the_title() ?>" title="<?php echo get_the_title() ?>" src="<?php echo getPost()->field('left_image', 'image_url') ?>"/>
                            </div>
                            <div class="half right-half">
                                <div class="navigation-tabs-section">
                                    <div class="navigation-tabs">
                                        <?php if (!$deactivateDownloadingUntil || $deactivateDownloadingUntil <= Date::get()) : ?>
                                            <button
                                                    class="navigation-tab button button-dark-blue"
                                                    data-active="button-dark-blue"
                                                    data-inactive="button-grey"
                                                    onclick="navigateToTab('online-tab'); hideMagazinCheckout()"
                                            >
                                                Online
                                            </button>
                                        <?php endif ?>

                                        <?php if ($productVariation) : ?>
                                            <button
                                                    class="navigation-tab button button-red"
                                                    data-active="button-dark-blue"
                                                    data-inactive="button-red"
                                                    onclick="navigateToTab('print-edition-tab'); addMagazinProductToCart(<?php echo (int) $productVariation->get_id() ?>, 'variation')"
                                            >
                                                Printausgabe
                                            </button>
                                        <?php endif ?>

                                        <?php if ($magazineProduct) : ?>
                                            <button
                                                    class="navigation-tab button button-grey"
                                                    data-active="button-dark-blue"
                                                    data-inactive="button-grey"
                                                    onclick="navigateToTab('subscribe-tab'); addMagazinProductToCart(<?php echo (int) $magazineProduct->get_id() ?>)"
                                            >
                                                Abonnieren
                                            </button>
                                        <?php endif ?>
                                    </div>
                                    <div class="navigation-tabs-content">
                                        <?php if (!$deactivateDownloadingUntil || $deactivateDownloadingUntil <= Date::get()) : ?>
                                            <div id="online-tab" class="navigation-tab-content">
                                                <!--[if lte IE 8]>
                                                <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2-legacy.js"></script>
                                                <![endif]-->
                                                <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2.js"></script>
                                                <script>
                                                    hbspt.forms.create({
                                                        portalId: '3856579',
                                                        formId: '<?php echo getPost()->field('right_hubspot') ?>'
                                                    });
                                                </script>
                                            </div>
                                        <?php endif ?>

                                        <?php if ($productVariation) : ?>
                                            <div id="print-edition-tab" class="navigation-tab-content">
                                                <?php echo get_field('print-edition-description') ?>
                                            </div>
                                        <?php endif ?>

                                        <?php if ($magazineProduct) : ?>
                                            <div id="subscribe-tab" class="navigation-tab-content">
                                                <?php echo get_field('magazine_abo_description', 'options') ?>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div>

                                <div
                                        id="omt-magazin-checkout"
                                        class="woocommerce-embed-checkout"
                                        style="display: <?php echo (!$deactivateDownloadingUntil || $deactivateDownloadingUntil <= Date::get()) ? 'none' : 'block' ?>"
                                >
                                    <?php echo do_shortcode('[woocommerce_checkout]') ?>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="omt-row wrap downloadtype-content">
                        <?php echo getPost()->field('inhaltseditor', 'content') ?>
                    </section>
                </article>
            </div>
        </div>
    </div>
<?php endif ?>

<?php get_footer(); ?>