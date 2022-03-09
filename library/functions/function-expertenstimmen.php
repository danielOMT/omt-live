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

function display_expertenstimmen(string $kategorie = "seo") {
    //*******************WEBINARE LOGIK VOM ALTEN OMT START*********************// ?>
    <?php
        $meta_query[] = array(
            'key' => 'kategorie',
            'value' => $kategorie,
            'compare' => 'LIKE'
        );
    if ($kategorie == "alle") {
        $post_types = array('magazin', 'emailmarketing', 'seo', 'sea', 'links', 'ga', 'content', 'social', 'facebook', 'affiliate', 'conversion', 'growthhack', 'amazon', 'wplugins', 'wpagespeed');
    }  else {
        $post_types = $kategorie;
    }

    $args = array( //next seminare 1st
        'posts_per_page'    => -1,
        'post_type'         => "expertenstimme",
        'order'				=> 'DESC',
        'orderby'			=> 'date',
        'meta_query'		=> $meta_query,
        'post_status' => array( 'publish', 'private'),
    );
    $loopexp = new WP_Query( $args );
    while ( $loopexp->have_posts() ) : $loopexp->the_post(); ?>
        <?php
        $id = get_the_ID();
        $experte = get_field('experte_speaker', $id);
        $speakerbeschreibung = get_field('speakerbeschreibung');
        $inhalt = get_field('inhalt');
        $speaker_image = get_field("profilbild", $experte->ID);
        $speaker_name = $experte->post_title;
        $speaker_link = get_the_permalink($experte->ID);
        ?>
        <div class="testimonial card clearfix expertenstimme">
            <h3 class="experte"><a target="_self" href="<?php print $speaker_link;?>"><?php print $speaker_name;?></a></h3>
            <h4 class="teaser-cat experte-info"><?php print $speakerbeschreibung;?></h4>
            <div class="testimonial-img">
                <a target="_self" href="<?php print $speaker_link;?>">
                    <img class="teaser-img" alt="<?php print $speaker_name; ?>" title="<?php print $speaker_name; ?>" src="<?php print $speaker_image['url'];?>">
                </a>
            </div>
            <div class="testimonial-text">
                <?php print $inhalt;?>
            </div>
        </div>
    <?php endwhile; //end
    wp_reset_postdata();
}