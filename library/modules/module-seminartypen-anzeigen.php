<?php
require_once ( get_template_directory() . '/library/functions/function-seminare.php');
seminarschema();
$seminare = $zeile['inhaltstyp'][0]['seminare'];
$count = 0;
$promotional = '';
$promotional_active = false;

$promos = $zeile['inhaltstyp'][0]['promo'];
foreach ($promos as $key) {
        $promo_title = $key['title'];
        $image = $key['image']['url'];
        $button_label = $key['button_label'];
        $link = $key['link'];
        $promotional = '
            <div class="teaser teaser-small box-col">
                <a href="#">
                    <img width=350" height=180" class="teaser-img seminar-image seminar-img" alt="'.$promo_title.'" title="'.$promo_title.'" src="'.$image.'"/>
                </a>
                <h4 class="seminarcat-title article-title">
                    <a href="'.$link.'">'.$promo_title.'</a>
                </h4>
                <div class="seminar-meta">
                </div>
                <a class="button  activate-form button-red " href="'.$link.'" title="'.$promo_title.'" data-effect="lightbox" data-id="form-'.$link.'">'.$button_label.'</a>
            </div>

            
             <div id="form-'.$link.'" class="contact-lightbox hidden">
                 '.do_shortcode("[gravityform ajax=true id='".$link."' title='true' description='true' tabindex='0']").'
             </div>
         ';
        break;
}


wp_reset_postdata();


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
        $promotiona_title = get_field('promotiona_title', $seminar['seminar']->ID);
        ?>
            <?php if($count == 4):
                echo $promotional;
            endif;?>
            
            <div class="teaser teaser-small box-col">
                <a href="<?php print $seminar_link ?>">
                    <img width=350" height=180" class="teaser-img seminar-image seminar-img" alt="<?php print $seminar_title ?>" title="<?php print $seminar_title; ?>" src="<?php print $image; ?>"/>
                </a>
                <h4 class="seminarcat-title article-title ">
                    <a href="<?php print $seminar_link ?>"><?php print $seminartitle_teaser; ?></a>
                </h4>
                <div class="seminar-meta">
                </div>
                <a class="button"  href="<?php print $seminar_link ?>" title="<?php print $seminar_title; ?>">Termine & Anmeldung</a>
            </div>
            
        
    <?php }
    $count++;
} ?>