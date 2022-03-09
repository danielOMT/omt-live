<?php

// Add Shortcode
function webinaranzahl( $atts ) {
    // Attributes
    $atts = shortcode_atts(
        array(
            //"id" => ""
        ),
        $atts
    );

    $args = array( //next seminare 1st
        'posts_per_page'    => -1,
        'post_type'         => 'webinare'
    );
    $webinarcount = 0;
    $today_date = date(strtotime("now"));  ////****get current time as unix string for future-check the entries
    $countloop = new WP_Query( $args );
    while ( $countloop->have_posts() ) : $countloop->the_post(); ?>
        <?php
        $webinar_datum = get_field("webinar_datum");
        $webinar_date_compare = strtotime($webinar_datum); //convert seminar date to unix string for future-check the entries ?>
        <?php if ($today_date >= $webinar_date_compare) {
            $webinarcount++;
        }
    endwhile;
    wp_reset_postdata();
    return $webinarcount;

}
add_shortcode( 'webinaranzahl', 'webinaranzahl' );
?>