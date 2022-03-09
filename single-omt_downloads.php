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
<?php if (getPost()->field('downloads_use_new_template', 'bool')) : 
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
            'deactivateUntil' => null
        ],
        'firstCheckoutButton' => (object) [
            'label' => getPost()->field('downloads_buy_button_label', 'text'),
            'product' => $orderProduct,
            // Force updating of embedded checkout because Stripe scripts are excluded from running on page load (measures for "page speed insights")
            'onClick' => "jQuery(document.body).trigger('update_checkout')"
        ]
    ]) ?>
<?php else : 
    $post_id = get_the_ID();
    $left_image = get_field('left_image');
    $hubspot_formular_id = get_field('right_hubspot');
    $inhaltseditor = get_field('inhaltseditor');
    $webinar_speaker = get_field('experte');
    $speaker_image = get_field("profilbild", $webinar_speaker->ID);
    $speaker_profil = get_field("beschreibung", $webinar_speaker->ID);
    $speaker_titel = get_field("titel", $webinar_speaker->ID);
    ?>

    <div id="content" class="" xmlns:background="http://www.w3.org/1999/xhtml">
        <?php /* <div class="hero-header" style="background: url('<?php print $hero_image['url'];?>') no-repeat 50% 0;">
            <div class="wrap">
                <h2 class="h1"><?php print $h1;?></h2>
            </div>
        </div>*/?>
        <div id="inner-content" class="wrap clearfix no-hero">
            <div id="main" class="omt-row blog-single  clearfix" role="main">
                <h1 class="entry-title single-title h2 has-margin-bottom-30" itemprop="headline"><?php the_title(); ?></h1>
                <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
                    <section class="entry-content clearfix" itemprop="articleBody">
                        <div class="content-intro clearfix">
                            <div class="half left-half">
                                <img class="download-image" alt="<?php print $left_image['alt'];?>" title="<?php print $left_image['alt'];?>" src="<?php print $left_image['url'];?>"/>
                            </div>
                            <div class="half right-half">
                                <!--[if lte IE 8]>
                                <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2-legacy.js"></script>
                                <![endif]-->
                                <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2.js"></script>
                                <script>
                                    hbspt.forms.create({
                                        portalId: '3856579',
                                        formId: '<?php print $hubspot_formular_id;?>'
                                    });
                                </script>
                                <!-- Button code -->
                            </div>
                        </div>
                    </section>
                    <section class="omt-row wrap downloadtype-content">
                        <?php print $inhaltseditor;?>
                    </section>
                    <section class="omt-row wrap">
                        <div class="testimonial card clearfix speakerprofil">
                            <h3 class="experte"><a target="_self" href="<?php print the_permalink($webinar_speaker->ID);?>"><?php print $webinar_speaker->post_title;?></a></h3>
                            <div class="testimonial-img">
                                <a target="_self" href="<?php print the_permalink($webinar_speaker->ID);?>">
                                    <img class="teaser-img" alt="<?php print $speaker_image['alt'];?>" title="<?php print $speaker_image['alt'];?>" src="<?php print $speaker_image['sizes']['350-180'];?>"/>
                                </a>
                            </div>
                            <div class="testimonial-text">
                                <?php print $speaker_profil;?>
                            </div>
                        </div>
                        <a class="button button-730px button-grey centered has-margin-top-30" href="<?php print get_permalink($webinar_speaker->ID);?>">Mehr über <?php print $webinar_speaker->post_title;?> erfahren</a>
                    </section>
                </article>
            </div>
            <?php //get_sidebar(); ?>
        </div>
    </div>
<?php endif; ?>
<?php get_footer(); ?>

