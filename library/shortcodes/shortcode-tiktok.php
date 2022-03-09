<?php

// Add Shortcode
function omt_tiktok( $atts ) {
    // Attributes
    $atts = shortcode_atts(
        array(
            "url" => "https://www.tiktok.com/@omt.de/video/6819239034808831238"
        ),
        $atts
    );


   /* return '<div class="vidembed_wrap ">
            <div class="vidembed">
                <iframe title="tiktok video player" src="https://www.tiktok.com/embed/'.$atts['id'].'?enablejsapi=1&origin=' . get_the_permalink() . '" frameborder="0"  allowfullscreen></iframe>
            </div></div>';*/
   return '<div class="tiktok-embed" data-url="' . $atts["url"] . '"></div>';
}
add_shortcode( 'tiktok', 'omt_tiktok' );
?>