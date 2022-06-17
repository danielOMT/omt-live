<?php

use OMT\Model\WooCart;
use OMT\Model\WooProduct;
use OMT\View\AuthorView;
use OMT\View\DownloadView;

$post_id = get_the_ID();
$experte = get_field('experte');

$orderProduct = WooProduct::init()->getProduct(
    getPost()->field('ebook_order_product', 'int')
);

if ($orderProduct) {
    wc_maybe_define_constant('WOOCOMMERCE_CHECKOUT', true);
    WooCart::init()->add($orderProduct);
}
?>
<?php get_header(); ?>

<?php if (getPost()->field('downloads_use_new_template', 'bool')) : ?>
    <?php echo DownloadView::loadTemplate('single', [
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
            'deactivateUntil' => null
        ],
        'firstCheckoutButton' => (object) [
            'label' => getPost()->field('downloads_buy_button_label', 'text'),
            'product' => $orderProduct,
            // Force updating of embedded checkout because Stripe scripts are excluded from running on page load (measures for "page speed insights")
            'onClick' => "jQuery(document.body).trigger('update_checkout')"
        ]
    ]) ?>
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
                                <?php if ($orderProduct) : ?>
                                    <div class="woocommerce-embed-checkout">
                                        <?php echo do_shortcode('[woocommerce_checkout]') ?>
                                        <?php // Force updating of embedded checkout because Stripe scripts are excluded from running on page load (measures for "page speed insights") ?>
                                        <script>jQuery(document.body).trigger('update_checkout')</script>
                                    </div>
                                <?php else : ?>
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
                                <?php endif ?>
                            </div>
                        </div>
                    </section>
                    <section class="omt-row wrap downloadtype-content">
                        <h2>Inhalt des eBooks <?php echo get_the_title() ?></h2>
                        <?php echo getPost()->field('inhaltseditor', 'content') ?>
                    </section>
                    <?php if ($experte && $experte->ID) : ?>
                        <section class="omt-row wrap experte-wrap">
                            <?php echo AuthorView::loadTemplate('profile-box', ['author' => $experte]) ?>
                        </section>
                    <?php endif ?>
                </article>
            </div>
        </div>
    </div>
<?php endif ?>

<?php get_footer(); ?>