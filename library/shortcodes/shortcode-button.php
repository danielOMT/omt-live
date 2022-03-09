<?php

function button( $atts, $content = null ) {
    $atts = shortcode_atts(
        array(
            "farbe" => "red",
            "link-target" => "#",
            "target" =>"_self"
        ),
        $atts
    );

    return '<div style="display:block;width:730px;max-width:100%;margin:0 auto 30px auto;"><a style="display:block;width:100%;" target="' . $atts['target'] . '" class="button button-' . $atts['farbe'] . ' widthauto" href="' . $atts['link-target'] . '">
                ' . $content . '
            </a></div>';
}
add_shortcode( 'button', 'button' );
add_shortcode( 'reachx_boxlink', 'button' );
?>