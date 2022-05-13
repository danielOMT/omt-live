<?php
function shortcode_lesezeit( $atts ) {
    $atts = shortcode_atts(
        array(
            "sticky" => 0),
        $atts
    );

    ob_start(); ?>
    <div class="article-header">
        <div class="info-wrap">
            <strong style="color:#ea506c !important;">Lesezeit: <?php echo reading_time(get_the_ID());?></strong>
            <div class="socials-header"><?php print do_shortcode('[shariff headline="Teile den Artikel" borderradius="1" buttonsize="small" services="facebook|twitter|googleplus|linkedin|xing" theme="round" orientation="horizontal" align="flex-end"]');?></div>
        </div>
    </div>
    <?php $result = ob_get_clean();


    return $result;
}
add_shortcode( 'lesezeit', 'shortcode_lesezeit' );
?>