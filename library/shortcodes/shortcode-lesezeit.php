<?php
function shortcode_lesezeit( $atts ) {
    $atts = shortcode_atts(
        array(
            "sticky" => 0),
        $atts
    );

    ob_start(); ?>
    <p style="color: #ea506c !important;"><strong>Lesezeit: <?php echo reading_time(get_the_ID());?></strong></p>
    <?php $result = ob_get_clean();


    return $result;
}
add_shortcode( 'lesezeit', 'shortcode_lesezeit' );
?>