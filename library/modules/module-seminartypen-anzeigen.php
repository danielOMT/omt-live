<?php
require_once ( get_template_directory() . '/library/functions/function-seminare.php');
seminarschema();
$seminare = $zeile['inhaltstyp'][0]['seminare'];
foreach ($seminare as $seminar) {
    if ((get_post_status($seminar['seminar']->ID) != 'draft') AND (get_post_status($seminar['seminar']->ID) != "private")) {
        $seminar_image = "asdf";
        $seminar_link = get_the_permalink($seminar['seminar']->ID);
        $vorschau = get_field('seminar_vorschau-headline', $seminar['seminar']->ID);
        $seminar_title = get_the_title($seminar['seminar']->ID);
        if (strlen($vorschau) > 0) {
            $seminar_title = $vorschau;
        }
        $seminartitle_teaser = $seminar_title;
        if (strlen($seminartitle_teaser) > 60) {
            $seminartitle_teaser = substr($seminartitle_teaser, 0, 60) . "...";
        };
        $seminar_woocommerce = get_field('seminar_woocommerce', $seminar['seminar']->ID);
        $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($seminar_woocommerce->ID), 'full');
        $image = $featured_image[0];

        ?>
        <div class="teaser teaser-small">
            <a href="<?php print $seminar_link ?>">
                <img width=350" height=180" class="teaser-img seminar-image" alt="<?php print $seminar_title ?>" title="<?php print $seminar_title; ?>" src="<?php print $image; ?>"/>
            </a>
            <h4 class="seminarcat-title article-title">
                <a href="<?php print $seminar_link ?>"><?php print $seminartitle_teaser; ?></a>
            </h4>
            <div class="seminar-meta">
            </div>
            <a class="button" href="<?php print $seminar_link ?>" title="<?php print $seminar_title; ?>">Termine & Anmeldung</a>
        </div>
    <?php }
} ?>