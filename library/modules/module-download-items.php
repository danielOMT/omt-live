<?php

use OMT\Model\Ebook;
use OMT\Model\WooCart;
use OMT\Model\WooProduct;
use OMT\Module\DownloadItems;
use OMT\Services\Date;

$today = date("Y-m-d", strtotime("today"));
$taxonomyQuery = null;
$module = new DownloadItems($zeile['inhaltstyp'][0]);

if ($module->category_id) {
    $taxonomy = 'download-category';

    switch ($module->post_type) {
        case 'omt_student':
            $taxonomy = 'student-category';
            break;

        case 'omt_ebook':
            $taxonomy = 'ebook-category';
            break;

        case 'omt_magazin':
            $taxonomy = 'magazin-category';
            break;
    }

    $taxonomyQuery = [[
        'taxonomy' => $taxonomy,
        'field' => 'term_id',
        'terms' => $module->category_id,
    ]];
}

$downloadPosts = get_posts([
    'posts_per_page' => $module->count ?: 3,
    'post_type' => $module->post_type,
    'tax_query' => $taxonomyQuery,
    'offset' => $module->offset ? $module->offset - 1 : null
]);

foreach ($downloadPosts as $downloadPost) {
    $downloadPost->download_url = get_the_permalink($downloadPost->ID);
    $downloadPost->magazinbestellung_produktvariante_id = get_field("magazinbestellung_produktvariante_id", $downloadPost->ID);
    $downloadPost->download_image = get_field("vorschaubild", $downloadPost->ID);
    $downloadPost->download_title = get_field("vorschautitel", $downloadPost->ID) ?: $downloadPost->post_title;
    $downloadPost->download_description = strip_tags(get_field("vorschautext", $downloadPost->ID));
    $downloadPost->download_product_variation = WooProduct::init()->getVariation(
        get_field("magazinbestellung_produktvariante_id", $downloadPost->ID)
    );

    if ($module->post_type == 'omt_ebook') {
        $downloadPost->category = Ebook::init()->getCategory($downloadPost);
        $downloadPost->order_product_id = get_field("ebook_order_product", $downloadPost->ID);
    }

    if (in_array($module->post_type, ['omt_ebook', 'omt_student', 'omt_downloads'])) {
        $downloadPost->author = get_field("experte", $downloadPost->ID);
    }
}

wp_enqueue_script('alpine-lines-clamping', get_template_directory_uri() . '/library/js/core/lines-clamping.js');
wp_enqueue_script('alpinejs', get_template_directory_uri() . '/library/js/libs/alpine.min.js');
?>

<?php foreach ($downloadPosts as $key => $downloadPost) : ?>
    <?php if ($key == 0 && $module->first_to_featured) : ?>
        <div class="x-mb-16">
            <div class="webinar-teaser card clearfix download-featured-item">
                <div class="webinar-teaser-img">
                    <a target="_blank" href="<?php echo $downloadPost->download_url ?>" title="<?php echo $downloadPost->download_title ?>">
                        <div class="teaser-image-wrap">
                            <img class="webinar-image teaser-img"
                                 width="350"
                                 height="190"
                                 alt="<?php echo $downloadPost->download_title ?>"
                                 title="<?php echo $downloadPost->download_title ?>"
                                 src="<?php echo $downloadPost->download_image['sizes']['350-180']; ?>"
                            />
                        </div>
                    </a>
                </div>
                <div class="webinar-teaser-text">
                    <a class="h4 article-title no-ihv" target="_blank" href="<?php echo $downloadPost->download_url ?>" title="<?php echo $downloadPost->download_title ?>"><?php echo $downloadPost->download_title ?></a>

                    <?php if ($module->post_type == 'omt_ebook') : ?>
                        <div class="x-mt-2">
                            <?php if (empty($downloadPost->category->associated_theme_page) || $downloadPost->category->associated_theme_page == get_the_permalink(get_the_ID())) : ?>
                                <span class="teaser-cat category-link"><?php echo $downloadPost->category->name ?></span>
                            <?php else : ?>
                                <a class="teaser-cat category-link" href="<?php echo $downloadPost->category->associated_theme_page ?>"><?php echo $downloadPost->category->name ?></a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($downloadPost->download_description)) : ?>
                        <div class="vorschautext has-margin-top-30 has-margin-bottom-30"><?php echo $downloadPost->download_description ?></div>
                    <?php endif; ?>

                    <a target="_blank" href="<?php echo $downloadPost->download_url ?>" title="<?php echo $downloadPost->download_title ?>" class="button button-red x-mt-2">
                        <?php if ( ($module->post_type == 'omt_ebook' && $downloadPost->order_product_id) OR ($module->post_type == 'omt_ebook' && $downloadPost->magazinbestellung_produktvariante_id) ): ?>
                            kostenpflichtig bestellen
                        <?php else : ?>
                            kostenlos herunterladen
                        <?php endif; ?>
                    </a>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="teaser teaser-small teaser-matchbuttons">
            <div class="teaser-image-wrap">
                <a href="<?php echo $downloadPost->download_url ?>" title="#">
                    <img width="350" height="180" class="teaser-img" alt="<?php echo $downloadPost->download_title ?>" title="<?php echo $downloadPost->download_title ?>" src="<?php echo $downloadPost->download_image['sizes']['350-180']; ?>" />
                    <img width="350" height="42" alt="OMT Download" title="OMT Download" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-350.png">
                </a>
            </div>
            <h2 class="h4 no-ihv teaser-two-lines-title">
                <a
                        x-data="xLinesClamping()"
                        x-init="clamp(2)"
                        href="<?php echo $downloadPost->download_url ?>"
                        title="<?php echo htmlspecialchars($downloadPost->download_title) ?>"
                >
                    <?php echo truncateString($downloadPost->download_title) ?>
                </a>
            </h2>

            <?php if ($module->post_type == 'omt_ebook') : ?>
                <?php if (empty($downloadPost->category->associated_theme_page) || $downloadPost->category->associated_theme_page == get_the_permalink(get_the_ID())) : ?>
                    <span class="teaser-cat category-link"><?php echo $downloadPost->category->name ?></span>
                <?php else : ?>
                    <a class="teaser-cat category-link" href="<?php echo $downloadPost->category->associated_theme_page ?>"><?php echo $downloadPost->category->name ?></a>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (in_array($module->post_type, ['omt_ebook', 'omt_student', 'omt_downloads']) && $downloadPost->author) : ?>
                <p class="experte no-margin-top no-margin-bottom">
                    <?php if ($downloadPost->author->ID == get_the_ID()) : ?>
                        <span><?php echo get_the_title($downloadPost->author) ?></span>
                    <?php else : ?>
                        <a href="<?php echo get_the_permalink($downloadPost->author) ?>"><?php echo get_the_title($downloadPost->author) ?></a>
                    <?php endif ?>
                </p>
            <?php endif ?>

            <div class="x-mt-2">
                <?php
                $downloadID = $downloadPost->ID;
                $deactivate_downloading_until = get_field('deactivate_downloading_until', $downloadID);
                if ($today>=$deactivate_downloading_until) { ?>
                    <a class="button" href="<?php echo $downloadPost->download_url ?>">
                        <?php if ($module->post_type == 'omt_ebook' && $downloadPost->order_product_id) : ?>
                            kostenpflichtig bestellen
                        <?php else : ?>
                            kostenlos herunterladen<?php
                            ?>
                        <?php endif; ?>
                    </a>
                <?php } ?>

                <?php if ($downloadPost->download_product_variation) : ?>
                    <a class="button download-checkout-url" href="<?php echo WooCart::init()->productVariationCheckoutUrl($downloadPost->download_product_variation) ?>">Printausgabe bestellen</a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach ?>