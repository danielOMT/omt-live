<?php
function shortcode_lesezeit( $atts ) {
    $atts = shortcode_atts(
        array(
            "sticky" => 0),
        $atts
    );

    ob_start(); ?>
    <strong>Lesezeit: <?php echo reading_time(get_the_ID());?></strong>
    <?php $result = ob_get_clean();


    return $result;
}
add_shortcode( 'lesezeit', 'shortcode_lesezeit' );
?>