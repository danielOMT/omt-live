<?php

// Add Shortcode
function omt_youtube( $atts ) {

    // Attributes
    $atts = shortcode_atts(
        array(
            "id" => "",
            "class" => ""
        ),
        $atts
    );
    $helper = strip_tags($atts['class']);
   /* return '<div class="vidembed_wrap ">
            <div class="vidembed">
                <iframe title="YouTube video player" src="https://www.youtube.com/embed/'.$atts['id'].'?enablejsapi=1&origin=' . get_the_permalink() . '" frameborder="0"  allowfullscreen></iframe>
            </div></div>';*/
   return '<div class="vidembed_wrap "><div class="youtube lazy-youtube '.$helper.'" data-embed="' . $atts['id'] . '">
<div class="play-button"></div>
</div></div>';

}
add_shortcode( 'youtube', 'omt_youtube' );
?>