<?php

// Add Shortcode
function omt_podigee( $atts ) {
    // Attributes
    $atts = shortcode_atts(
        array(
            "token" => "XjsiTYbQY6fhYPb_ttA6Yw"
        ),
        $atts
    );

   return '<script class="podigee-podcast-player" src="https://cdn.podigee.com/podcast-player/javascripts/podigee-podcast-player.js" data-configuration="https://omt-podcast.podigee.io/embed?context=external&token=XjsiTYbQY6fhYPb_ttA6Yw"></script>';

}
add_shortcode( 'podigee', 'omt_podigee' );
?>


