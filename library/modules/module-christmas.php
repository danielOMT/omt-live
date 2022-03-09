<?php
if (1 == $zeile['inhaltstyp'][0]['alle_christmas']) {
    $christmas_links = get_posts(array(
                'post_type' => 'christmas',
                'posts_per_page'    => -1,
                'post_status' => array( 'publish', 'future'),
                'orderby'           => 'date',
                'order'				=> 'ASC',
            ));
            $seiten_auswahlen = array();
            foreach ($christmas_links as $christmas_link) {
                $seiten_auswahlen[] = $christmas_link->ID;
            }
} else {
    $seiten_auswahlen = $zeile['inhaltstyp'][0]['seiten_auswahlen'];
}
foreach ($seiten_auswahlen as $seite) {
    $item = get_post($seite);
    $img = get_field('kalender_vorschaubild', $seite);
    $title = get_the_title($ID);
    $class = '';
    if ($item->post_status == 'future') {
        $class = 'class="teaser teaser-small buttonbutton-christmas grayscaled-image"';
    }
    ?>
    <?php if($item->post_status == 'publish'){?>
        <a class="teaser teaser-small buttonbutton-christmas" href="<?php print get_the_permalink($seite);?>">
    <?php }?>
            <img <?php echo $class?> src="<?php echo $img['sizes']['350-90'] ?>">
    <?php if($item->post_status == 'publish'){?>
        </a>
    <?php }?>
<?php } ?>

<div class="x-absolute christmas-top-left-img">
    <img src="<?php echo $zeile['inhaltstyp'][0]['top-left-image']['sizes']['medium_large'] ?>">
</div>
<div class="x-absolute christmas-bottom-right-img">
    <img src="<?php echo $zeile['inhaltstyp'][0]['bottom_right_image']['sizes']['medium_large'] ?>">
</div>