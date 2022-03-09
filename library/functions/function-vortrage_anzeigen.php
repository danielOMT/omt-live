<?php
/**
Function to Display Webinare by Parameters given from user.
 * Params:
 * Anzahl
 * Title_only?
 * Kategorie
 * Autor
 * Status (zukünftige, vergangene, alle)
 */

function display_vortraege(int $jahr = 2018) {
    //*******************WEBINARE LOGIK VOM ALTEN OMT START*********************// ?>
    <?php
    $args = array( //next
        'posts_per_page'    => -1,
        'post_type'         => "vortrag",
        'posts_status'      => "publish",
        'year'              => $jahr,
        'order'				=> 'DESC',
        'orderby'			=> 'date',
    );
    $loop = new WP_Query( $args );
    while ( $loop->have_posts() ) : $loop->the_post(); ?>
        <?php
        $speaker = get_field('speaker');
        $speaker_image = get_field("profilbild", $speaker->ID);
        $image_teaser = $speaker_image['sizes']['350-180'];
        $title = get_the_title();
        if (strlen($title)>65) { $title = substr($title, 0, 65) . "..."; } ;
        //$webinar_shorttitle = implode(' ', array_slice(explode(' ', $title), 0, 7));
        //$wordcount = str_word_count($title);
        //if ($wordcount > 7) { $title = $webinar_shorttitle . "..."; }
        ?>
        <div class="teaser teaser-small teaser-matchbuttons">
            <div class="teaser-image-wrap" style="">
                <img class="webinar-image teaser-img" alt="<?php the_title();?>" title="<?php the_title();?>" src="<?php print $image_teaser;?>"/>
                <img alt="OMT Vortrag" title="OMT Vortrag" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-350.png" style="">
            </div>
            <h4 class="article-title"><a href="<?php the_permalink()?>" title="<?php the_title_attribute(); ?>"><?php print $title; ?></a></h4>
            <p class="experte no-margin-top no-margin-bottom">
                <a target="_self" href="<?php print get_the_permalink($speaker->ID);?>"><?php print get_the_title($speaker->ID); ?></a>
            </p>
            <a class="button" href="<?php the_permalink()?>" title="<?php the_title_attribute(); ?>">Vortrag anschauen</a>
        </div>
    <?php endwhile; //end
    wp_reset_postdata();?>

    <?php
}