<?php

function kontakt_button( $atts, $content = null ) {
    $atts = shortcode_atts(
        array(
            "farbe" => "red",
            "link-target" => "#",
            "target" =>"_self"
        ),
        $atts
    );

    return '<div class="contact-modal"><a class="agentursuche-button button button-red" href="#kontakt">
                ' . $content . '
            </a></div>';
}
add_shortcode( 'kontakt_button', 'kontakt_button' );
add_shortcode( 'kontakt_button', 'kontakt_button' );
?>